<?php

namespace App\Exports;

use Generator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\FromCollection;

class WarehouseExport implements FromGenerator, WithHeadings
{
    private $generator;

    public function __construct($generator)
    {
        $this->generator = $generator;
    }

    public function generator() : Generator
    {
        return $this->generator;
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Email',
            'Phone',
            'Address',
            'Active',
        ];
    }
}
