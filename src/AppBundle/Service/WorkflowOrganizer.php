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

    public function processCSVFile($file)
    {
        $fileObject = new \SplFileObject($file);
        $fileObject->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $this->reader = new CsvReader($fileObject, ',');
        $this->reader->setHeaderRowNumber(0);
        $this->writer = new DoctrineWriter($this->em, Product::class);
        $this->writer->prepare();
        $this->workflow = $this->createWorkflow();
        $result = $this->workflow->process();

        echo $result->getErrorCount();
        echo '<hr>';
        echo $result->getSuccessCount();
        echo '<hr>';
        echo $result->getTotalProcessedCount();
        echo '<hr>';
    }

    private function createWorkflow()
    {
        $workflow = new Workflow($this->reader);
        $workflow->addWriter($this->writer);
        $workflow->addStep($this->filterStep->generateFilterStep());
        $workflow->addStep($this->converterStep->generateConvertStep());
        $workflow->addStep($this->mappingStep->generateMappingStep());
        return $workflow;
    }







}