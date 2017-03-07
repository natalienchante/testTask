<?php

namespace AppBundle\Service;

use Port\Steps\Step\FilterStep;

class FilterService
{
    public function generateFilterStep()
    {
        $filterStep = new FilterStep();
        $filterStep->add(function ($input) { return $this->isValidPrice($input['Cost in GBP']); });
        $filterStep->add(function ($input) { return $this->isValidStock($input['Stock']); });
        $filterStep->add(function ($input) { return $this->isValidDiscontinued($input['Discontinued']); });
        return $filterStep;
    }

    private function isValidPrice($value)
    {
        return is_numeric($value) && $value >= 5 && $value <= 1000 ? true : false;
    }

    private function isValidStock($value)
    {
        return isset($value) && is_numeric($value) && $value >= 10 ? true : false;
    }

    private function isValidDiscontinued($value)
    {
        return $value =='yes' || $value == '' ? true : false;
    }
}