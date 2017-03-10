<?php

namespace AppBundle\Entity;

/**
 * Class CSVFile
 * @package AppBundle\Entity
 */
class CSVFile
{
    protected $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null $file
     */
    public function setFile($file = null)
    {
        $this->file = $file;
    }
}
