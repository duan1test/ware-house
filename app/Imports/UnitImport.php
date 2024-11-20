<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UnitImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    private $addedCount = 0;
    private $updatedCount = 0;
    private $errors = [];

    public function model(array $row)
    {
        $unit = Unit::where('code', $row['code'])->first();
        if ($row['base_unit'] != null) {
            $base_unit = Unit::where('code', $row['base_unit'])->first();
        }
        if ($unit) {
            $unit->update([
                'name'              => $row['name'],
                'code'              => $row['code'],
                'base_unit_id'      => isset($base_unit) ? $base_unit->id : null,
                'operator'          => $row['operator'],
                'operation_value'   => $row['operation_value'],
            ]); 
            $this->updatedCount++;
        } else {
            Unit::create([
                'name'              => $row['name'],
                'code'              => $row['code'],
                'base_unit_id'      => isset($base_unit) ? $base_unit->id : null,
                'operator'          => $row['operator'],
                'operation_value'   => $row['operation_value'],
            ]);
            $this->addedCount++;
        }

        return $unit;
    }

    public function getAddedCount()
    {
        return $this->addedCount;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }


    public function getErrors()
    {
        return $this->errors;
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'max:255'],
            'operation_value' => ['nullable', 'numeric'],
            'operator'        => ['nullable', 'in:+,-,*,/'],
            'base_unit'       => ['nullable', 'exists:units,code'],
            'code'            => ['required', 'alpha_num', 'max:50',],
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $values = $failure->values();
            $errors = $failure->errors();
            $this->errors[] = [
                ...$values,
                'error' => implode(",", $errors)
            ];
        }
    }

    public function customValidationMessages()
    {
        return [
            'code.max'                  => 'Trường code không vượt quá 50 ký tự.',
            'name.max'                  => 'Trường name không vượt quá 255 ký tự.',
            'name.required'             => 'Name là bắt buộc.',
        ];
    }
}
