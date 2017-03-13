<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Port\Steps\StepAggregator as Workflow;
use Port\Csv\{CsvReaderFactory, CsvReader};


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
     * @var DoctrineWriterFactory
     */
    private $doctrineWriterFactory;

    /**
     * @var CsvReaderFactory
     */
    private $csvReaderFactory;

    /**
     * WorkflowOrganizer constructor.
     *
     * @param FilterService          $filterStep
     * @param ConverterService       $converterStep
     * @param MappingService         $mappingStep
     * @param CsvReaderFactory       $csvReaderFactory
     * @param DoctrineWriterFactory  $doctrineWriterFactory
     */
    public function __construct(
        FilterService $filterStep,
        ConverterService $converterStep,
        MappingService $mappingStep,
        CsvReaderFactory $csvReaderFactory,
        DoctrineWriterFactory $doctrineWriterFactory
    ) {
        $this->filterStep = $filterStep;
        $this->converterStep = $converterStep;
        $this->mappingStep = $mappingStep;
        $this->csvReaderFactory = $csvReaderFactory;
        $this->doctrineWriterFactory = $doctrineWriterFactory;
    }

    /**
     * @param \SplFileObject $filename
     * @param bool   $test
     *
     * @return array
     */
    public function processCSVFile(\SplFileObject $fileObject, $test=false)
    {
        $this->workflow = $this->createWorkflow($this->csvReaderFactory->getReader($fileObject));
        if (!$test) {
            $this->workflow->addWriter($this->generateDoctrineWriter());
        }
        return ['result' => $this->workflow->process(), 'failedItems' => $this->workflow->getFailedItems()];
    }

    /**
     * @param CsvReader $reader
     *
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

    /**
     * @return \Port\Doctrine\DoctrineWriter
     */
    private function generateDoctrineWriter()
    {
        $writer = $this->doctrineWriterFactory->getDoctrineWriter(Product::class);
        $writer->prepare();
        return $writer;
    }
}