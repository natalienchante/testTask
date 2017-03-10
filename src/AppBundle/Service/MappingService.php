<?php

namespace AppBundle\Service;

use Port\Steps\Step\MappingStep;

/**
 * Class MappingService
 * @package AppBundle\Service
 */
class MappingService
{
    /**
     * @return MappingStep
     */
    public function generateMappingStep()
    {
        $mappingStep = new MappingStep();
        $mappingStep->map('[Product Code]', '[productCode]');
        $mappingStep->map('[Product Name]', '[name]');
        $mappingStep->map('[Product Description]', '[description]');
        $mappingStep->map('[Stock]', '[stock]');
        $mappingStep->map('[Cost in GBP]', '[price]');
        $mappingStep->map('[Discontinued]', '[dateTimeDiscontinued]');
        return $mappingStep;
    }
}