<?php
namespace AppBundle\Service;

use \KzykHys\CsvParser\CsvParser as Parser;

class CSVParser
{
    public function parseCSVFile($file)
    {
        $parser = Parser::fromFile($file);
        return $parser->parse();
    }
}

