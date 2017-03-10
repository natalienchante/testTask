<?php

use PHPUnit\Framework\TestCase;
use \AppBundle\Service\WorkflowOrganizer;
use \AppBundle\Service\FilterService;
use \AppBundle\Service\ConverterService;
use \AppBundle\Service\MappingService;
use \Doctrine\ORM\EntityManager;
use Port\Doctrine\DoctrineWriter;
use \Doctrine\Common\Persistence\Mapping\ClassMetadata;

class WorkflowOrganizerTest extends TestCase
{
    /**
     * @var WorkflowOrganizer
     */
    protected $workflowOrganizer;

    public function setUp()
    {
        $filterService = new FilterService();
        $converterService = new ConverterService();
        $mappingService = new MappingService();
        $em = $this->createMock(EntityManager::class);
        $cm = $this->getMockBuilder(ClassMetadata::class)
            ->setMethods(['getName'])
            ->getMock();
        $cm->expects($this->once())
            ->method('getName')
            ->willReturn('Doctrine Writer');
        $dw = $this->getMockBuilder(DoctrineWriter::class)
            ->setConstructorArgs(array($em, 'Doctrine Writer'))
            ->setMethods(['getClassMetadata'])
            ->getMock();
        $dw->expects($this->once())
            ->method('getClassMetadata')
            ->will($this->returnValue($cm));
        $wo = $this->getMockBuilder(WorkflowOrganizer::class)
            ->setMethods(['generateDoctrineWriter'])
            ->getMock();
        $wo->expects($this->once())
            ->method('generateDoctrineWriter')
            ->willReturn($dw);
        $this->workflowOrganizer = new WorkflowOrganizer($filterService, $converterService, $mappingService, $em);

//        $this->getMockBuilder(DoctrineWriter::class)->
    }

    /**
     * @dataProvider fileNameProvider
     */
    public function testProcessCSVFile($filename)
    {
        $this->assertEquals(0, $this->workflowOrganizer->processCSVFile($filename)->getTotalProcessedCount());
    }

    public function fileNameProvider()
    {
        return [
            ['1.csv'],
            ['2.csv'],
            ['3.csv'],
            ['4.csv'],
            ['5.csv'],
            ['6.csv'],
            ['7.csv']
        ];
    }
}