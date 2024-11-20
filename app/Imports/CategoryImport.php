<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    private $addedCount = 0;
    private $updatedCount = 0;
    private $errors = [];

    public function model(array $row)
    {
        $parentId = null;
        if (isset($row['parent'])) {
            $parent = Category::where('code', $row['parent'])->first();
            $parentId = $parent ? $parent->id : null;
        }

        $category = Category::where('code', $row['code'])->first();

        if ($category) {
            $category->update([
                'name' => $row['name'],
                'parent_id' => $parentId,
            ]);
            $this->updatedCount++;
        } else {
            Category::create([
                'code' => $row['code'],
                'name' => $row['name'],
                'parent_id' => $parentId,
            ]);
            $this->addedCount++;
        }

        return $category;
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
            'parent'    => 'nullable|max:255',
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
            'parent.max'            => 'Parent không vượt quá 255 ký tự.',
        ];
    }

}
