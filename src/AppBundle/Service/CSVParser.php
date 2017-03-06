<?php
namespace AppBundle\Service;

use Coseva\CSV as CSV;

class CSVParser
{
    public function parseCSVFile($file)
    {
        $csv = new CSV($file);
        return $csv->parse();
    }
}
