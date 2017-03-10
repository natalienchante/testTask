<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Port\Result;
use Port\Steps\StepAggregator as Workflow;
use Port\Csv\CsvReaderFactory;

/**
 * Class WorkflowOrganizer
 * @package AppBundle\Service
 */
class WorkflowOrganizer
{
    /**
     * @var FilterService
     */
    private $filterStep;

    /**
     * @var ConverterService
     */
    private $converterStep;

    /**
     * @var MappingService
     */
    private $mappingStep;

    /**
     * @var
     */
    private $workflow;

    /**
     * @var
     */
    private $writer;

//    /**
//     * @var
//     */
//    private $reader;

    private $doctrineWriterFactory;

    private $readerFactory;

    /**
     * WorkflowOrganizer constructor.
     *
     * @param FilterService          $filterStep
     * @param ConverterService       $converterStep
     * @param MappingService         $mappingStep
     * @param CsvReaderFactory       $readerFactory
     * @param DoctrineWriterFactory  $doctrineWriterFactory
     */
    public function __construct(
        FilterService $filterStep,
        ConverterService $converterStep,
        MappingService $mappingStep,
        CsvReaderFactory $readerFactory,
        DoctrineWriterFactory $doctrineWriterFactory
    ) {
        $this->filterStep = $filterStep;
        $this->converterStep = $converterStep;
        $this->mappingStep = $mappingStep;
        $this->readerFactory = $readerFactory;
        $this->doctrineWriterFactory = $doctrineWriterFactory;
    }

    /**
     * @param string $filename
     * @param bool   $test
     *
     * @return Result
     */
    public function processCSVFile($filename, $test=false)
    {
        $this->workflow = $this->createWorkflow($this->readerFactory->getReader(new \SplFileObject($filename)));
        if (!$test) {
            $this->workflow->addWriter($this->generateDoctrineWriter());
        }
        return $this->workflow->process();
    }

    /**
     * @return Workflow
     */
    private function createWorkflow($reader)
    {
        $workflow = new Workflow($reader);
        $workflow->addStep($this->filterStep->generateFilterStep());
        $workflow->addStep($this->converterStep->generateConvertStep());
        $workflow->addStep($this->mappingStep->generateMappingStep());
        return $workflow;
    }

    private function generateDoctrineWriter()
    {
        $writer = $this->doctrineWriterFactory->getDoctrineWriter(Product::class);
        $writer->prepare();
        return $writer;
    }
}