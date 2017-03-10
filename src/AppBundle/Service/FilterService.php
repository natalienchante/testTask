<?php

namespace AppBundle\Service;

use Port\Steps\Step\FilterStep;

/**
 * Class FilterService
 * @package AppBundle\Service
 */
class FilterService
{
    /**
     * @return FilterStep
     */
    public function generateFilterStep()
    {
        $filterStep = new FilterStep();
        $filterStep->add(function ($input) { return $this->isValidPrice($input['Cost in GBP']); });
        $filterStep->add(function ($input) { return $this->isValidStock($input['Stock']); });
        $filterStep->add(function ($input) { return $this->isValidDiscontinued($input['Discontinued']); });
        return $filterStep;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isValidPrice($value)
    {
        return is_numeric($value) && $value >= 5 && $value <= 1000;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isValidStock($value)
    {
        return is_numeric($value) && $value >= 10;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function isValidDiscontinued($value)
    {
        return $value =='yes' || $value == '';
    }
}