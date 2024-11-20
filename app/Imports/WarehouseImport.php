<?php

namespace App\Imports;

use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WarehouseImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $errors = [];
    private $addedCount = 0;
    private $updatedCount = 0;
    use Importable;
  
    public function model(array $row)
    {
        $warehouse = Warehouse::updateOrCreate(['code' => $row['code']], [
            'code'      => $row['code'],
            'name'      => $row['name'],
            'email'     => $row['email'] ?? '',
            'phone'     => $row['phone'] ?? '',
            'address'   => $row['address'] ?? '',
            'active'    => $row['active'] == 'yes',
        ]);

        if ($warehouse->wasRecentlyCreated) {
            $this->addedCount++;
        } else {
            $this->updatedCount++;
        }

        return $warehouse;
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
            'code'      => 'required|max:255',
            'name'      => 'required|max:255',
            'phone'     => 'nullable|digits_between:10,15|regex:/^[0-9]+$/',
            'email'     => 'nullable|email:filter|max:255',
            'address'   => 'nullable|max:255',
            'active'    => 'nullable',
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
            'code.required'         => 'Code là bắt buộc',
            'code.max'              => 'Code không vượt quá 255 ký tự.',
            'name.required'         => 'Name là bắt buộc',
            'name.max'              => 'Name không vượt quá 255 ký tự.',
            'phone.digits_between'  => 'Phone phải có từ 10 đến 15 số',
            'phone.regex'           => 'Phone không đúng định dạng',
            'email.email'           => 'Email không đúng định dạng',
            'email.max'             => 'Email không vượt quá 255 ký tự.',
            'address.max'           => 'Address không vượt quá 255 ký tự.',
        ];
    }

}
