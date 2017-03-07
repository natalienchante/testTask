<?php

namespace AppBundle\Service;

use Port\Steps\Step\ConverterStep;

class ConverterService
{
    public function generateConvertStep()
    {
        $convertStep = new ConverterStep();
        $convertStep->add(function($input) { return $this->updateDiscontinuedValue($input); });
        return $convertStep;
    }

    private function updateDiscontinuedValue($input)
    {
        $input['Discontinued'] = $input['Discontinued'] =='yes' ? new \DateTime() : null;
        return $input;
    }
}