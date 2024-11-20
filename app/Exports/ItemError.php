<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemError implements FromCollection,  WithHeadingRow, WithHeadings
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
}
