<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryError implements FromCollection,  WithHeadingRow, WithHeadings
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
            'code',
            'name',
            'parent'
        ];
    }
}
