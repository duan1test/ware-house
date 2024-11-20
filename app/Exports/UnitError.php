<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitError implements FromCollection,  WithHeadingRow, WithHeadings
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }
   
    public function collection()
    {
        return collect($this->errors);
    }

    public function headings(): array
    {
        return [
            'name',
            'code',
            'base_unit',
            'operator',
            'operation_value'  
        ];
    }
}
