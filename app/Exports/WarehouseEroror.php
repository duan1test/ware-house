<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WarehouseEroror implements FromCollection,  WithHeadingRow, WithHeadings
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
            'email',
            'phone',
            'address',
            'active'
        ];
    }
}
