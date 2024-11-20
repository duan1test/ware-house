<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    private $addedCount = 0;
    private $updatedCount = 0;
    private $errors = [];

    public function model(array $row)
    {
        $contact = Contact::where('email', $row['email'])->first();
        if ($contact) {
            $contact->update([
                'name' => $row['name'],
                'phone' => $row['phone'],
                'details' => $row['details'],
            ]); 
            $this->updatedCount++;
        } else {   
            Contact::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'details' => $row['details'],
                'account_id' => Auth::user()->account_id?Auth::user()->account_id:Auth::user()->id,
            ]);
            $this->addedCount++;
        }

        return $contact;
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|email:rfc,dns|max:255',
            'phone'     => 'nullable|regex:/^[0-9]+$/|digits_between:10,15',
            'details'   => 'nullable|string',
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
            'email.required'        => 'Email là bắt buộc.',
            'email.max'             => 'Email không vượt quá 255 ký tự.',
            'name.required'         => 'Name là bắt buộc.',
            'name.max'              => 'Name không vượt quá 255 ký tự.',
        ];
    }

}
