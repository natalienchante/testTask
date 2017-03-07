<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Port\Steps\StepAggregator as Workflow;
use Port\Csv\CsvReader;
use Port\Doctrine\DoctrineWriter;

class WorkflowOrganizer
{
    private $filterStep;
    private $converterStep;
    private $mappingStep;
    private $workflow;
    private $writer;
    private $reader;

    public function __construct(
        FilterService $filterStep,
        ConverterService $converterStep,
        MappingService $mappingStep,
        $em
    ) {
        $this->filterStep = $filterStep;
        $this->converterStep = $converterStep;
        $this->mappingStep = $mappingStep;
        $this->em = $em;
    }

    public function processCSVFile($filename, $test=false)
    {
        $fileObject = new \SplFileObject($filename);
        $fileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $this->reader = new CsvReader($fileObject, ',');
        $this->reader->setHeaderRowNumber(0);
        if (!$test) {
            $this->writer = new DoctrineWriter($this->em, Product::class);
            $this->writer->prepare();
        }
        $this->workflow = $this->createWorkflow($test);
        $result = $this->workflow->process();

        echo 'Всего ошибок: '.$result->getErrorCount();
        echo "\n";
        echo 'Успешно: '.$result->getSuccessCount();
        echo "\n";
        echo 'Всего обработано: '.$result->getTotalProcessedCount();
        echo "\n";
    }

    private function createWorkflow($test=false)
    {
        $workflow = new Workflow($this->reader);
        if (!$test) {
            $workflow->addWriter($this->writer);
        } // переделать
        $workflow->addStep($this->filterStep->generateFilterStep());
        $workflow->addStep($this->converterStep->generateConvertStep());
        $workflow->addStep($this->mappingStep->generateMappingStep());
        return $workflow;
    }







}