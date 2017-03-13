<?php

namespace tests\AppBundle\Service;

use AppBundle\Service\MockFactory;
use PHPUnit\Framework\TestCase;

class ConverterServiceTest extends TestCase
{
    /**
     * @var
     */
    protected $workflowOrganizer;

    /**
     * @var
     */
    protected $savedItem;

    /**
     * @param $data
     *
     * @dataProvider dataProvider
     */
    public function testConverterService($data)
    {
        $mockFactory = new MockFactory();
        $this->workflowOrganizer = $mockFactory->createWorkflowOrganizer($data);
        $this->workflowOrganizer->processCSVFile(new \SplFileObject('php://memory'), true);
        $date = new \DateTime($this->savedItem['Discontinued']);
        if ($data['isDateTime']) {
            $this->assertInstanceOf(\DateTime::class, $date);
        } else {
            $this->assertEquals($this->savedItem['Discontinued'], $data['row']['Discontinued']);
        }
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            1 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 15,
                'Discontinued' => 'yes'
            ], 'isDateTime' => true]],
            2 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 4,
                'Discontinued' => ''
            ], 'isDateTime' => false]],
            3 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 10,
                'Discontinued' => ''
            ], 'isDateTime' => false]],
        ];
    }
}