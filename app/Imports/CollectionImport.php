<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CollectionImport implements ToModel, WithHeadingRow
{
    private $collection;

    public function model(array $row)
    {
        $this->collection[] = $row;
    }

    public function getCollection()
    {
        return $this->collection;
    }
}