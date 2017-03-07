<?php

namespace AppBundle\Service;

use Port\Steps\Step\MappingStep;

class MappingService
{
    public function generateMappingStep()
    {
        $mappingStep = new MappingStep();
//        $from = ['Product Code', 'Product Name', 'Product Description', 'Stock', 'Cost in GBR', 'Discontinued'];
//        $to = ['strProductCode', 'strProductName', 'strProductDesc', 'intProductStock', 'numProductPrice', 'dtmDiscontinued'];
//        $mappingStep->map($from, $to);
        $mappingStep->map('[Product Code]', '[productCode]');
        $mappingStep->map('[Product Name]', '[name]');
        $mappingStep->map('[Product Description]', '[description]');
        $mappingStep->map('[Stock]', '[stock]');
        $mappingStep->map('[Cost in GBP]', '[price]');
        $mappingStep->map('[Discontinued]', '[dateTimeDiscontinued]');
        return $mappingStep;
    }
}