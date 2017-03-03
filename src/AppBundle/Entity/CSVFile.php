<?php

namespace AppBundle\Entity;

class CSVFile
{
    protected $file;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file = null)
    {
        $this->file = $file;
    }
}
