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
     * @var array
     */
    private $failedItems = [];

    /**
     * @return FilterStep
     */
    public function generateFilterStep()
    {
        $filterStep = new FilterStep();
        return $filterStep->add(function ($input) {
            return $this->isValidInput($input);
        });
    }

    /**
     * @return array
     */
    public function getFailedItems()
    {
        return $this->failedItems;
    }

    /**
     * @param $input
     *
     * @return bool
     */
    private function isValidInput($input)
    {
        if ($this->isValidPrice($input['price'])
            && $this->isValidStock($input['stock'])
            && $this->isValidDiscontinued($input['dateTimeDiscontinued'])
        ) {
            return true;
        } else {
            $this->failedItems[] = $input;
            return false;
        }
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
        return $value == 'yes' || $value == '';
    }
}