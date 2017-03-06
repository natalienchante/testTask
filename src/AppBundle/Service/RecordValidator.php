<?php

namespace AppBundle\Service;

class RecordValidator
{
    public function validateRecords($parsedFile)
    {
        $validatedRecords = [];
        foreach ($parsedFile as $row) {
            if ($this->isValidForInsert($row)) {
                $validatedRecords[] = $row;
            }
        }
        return $validatedRecords;
    }

    private function isValidForInsert($row)
    {
        return (isset($row[3]) && is_numeric($row[3])) && is_numeric($row[4]) && ($row[5]=='yes' || $row[5] == '');
    }
}