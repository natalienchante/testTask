<?php

namespace tests\AppBundle\Service;

use AppBundle\Service\MockFactory;
use PHPUnit\Framework\TestCase;

class FilterServiceTestTest extends TestCase
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
    public function testFilterCSVFile($data)
    {
        $mockFactory = new MockFactory();
        $this->workflowOrganizer = $mockFactory->createWorkflowOrganizer($data);
        $this->assertEquals($data['count'], count($this->workflowOrganizer->
            processCSVFile(new \SplFileObject('php://memory'), true)['failedItems']));
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
            'Cost in GBP' => 'Hello',
            'Discontinued' => ''
            ], 'count' => 1]],
            2 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 4,
                'Discontinued' => ''
            ], 'count' => 1]],
            3 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 1010,
                'Discontinued' => 'yes'
            ], 'count' => 1]],
            4 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 'why',
                'Cost in GBP' => 50,
                'Discontinued' => 'yes'
            ], 'count' => 1]],
            5 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 3,
                'Cost in GBP' => 50,
                'Discontinued' => 'yes'
            ], 'count' => 1]],
            6 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 10,
                'Discontinued' => 'hi'
            ], 'count' => 1]],
            7 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 4,
                'Discontinued' => 0
            ], 'count' => 1]],
            8 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 12,
                'Discontinued' => 'yes'
            ], 'count' => 0]],
            7 => [['row' => [
                'Product Code' => 'P0002',
                'Product Name' => 'TV',
                'Product Description' => '32” Tv',
                'Stock' => 10,
                'Cost in GBP' => 20,
                'Discontinued' => ''
            ], 'count' => 0]],
        ];
    }

}