<?php

namespace AppBundle\Service;

use Port\Steps\Step\ConverterStep;

/**
 * Class ConverterService
 * @package AppBundle\Service
 */
class ConverterService
{
    /**
     * @return ConverterStep
     */
    public function generateConvertStep()
    {
        $convertStep = new ConverterStep();
        $convertStep->add(function($input) { return $this->updateDiscontinuedValue($input); });
        return $convertStep;
    }

    /**
     * @param $input
     *
     * @return mixed
     */
    private function updateDiscontinuedValue($input)
    {
//        $date = new \DateTime();
        $input['Discontinued'] = strval($input['Discontinued']) == 'yes' ? $date = new \DateTime() : null;
        return $input;
    }
}