<?php

namespace App\Exports;

use Generator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ItemExport implements FromGenerator, WithHeadings, ShouldAutoSize, WithColumnFormatting
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
            __('attributes.item.name'),
            __('attributes.item.code'),
            __('attributes.item.sku'),
            __('attributes.item.barcode_symbology'),
            __('attributes.item.unit'),
            __('attributes.item.category'),
            __('attributes.item.details'),
            __('attributes.item.has_serial'),
            __('attributes.item.track_weight'),
            __('attributes.item.track_quantity'),
            __('attributes.item.alert_quantity'),
            __('attributes.item.has_variant'),
            __('attributes.item.variants'),
            __('attributes.item.rack_location'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => '0.00',
        ];
    }
}
