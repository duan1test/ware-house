<?php

namespace App\Http\Controllers\Port;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactError;
use App\Exports\ContactExport;
use App\Http\Requests\ImportRequest;
use App\Imports\ContactImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;

class ContactPortController extends Controller
{
    public function import() {
        return view('pages.contact.import');
    }

    public function export() {
         return Excel::download(new ContactExport($this->categoryGenerator()), 'contacts.xlsx');
    }
    public function save(ImportRequest $request) {
        try {
            $import = new ContactImport();
            Excel::import($import, $request->validated()['excel']);
            $errors = $import->getErrors();
            $addedCount = $import->getAddedCount();
            $updatedCount = $import->getUpdatedCount();

            if (!empty($errors)) {
                $errorFileUrl = $this->handleErrorFile($import);
                return redirect()->back()->with([
                    'error' => __('messages.import.error'),
                    'download' => $errorFileUrl,
                ]);
            }

            return redirect()->route('contacts.index')->with('success', __('messages.import.success', [
                'added' => $addedCount,
                'updated' => $updatedCount,
            ]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with([
                'error' => __('messages.import.error'),
            ]);
        }
    }

    public function handleErrorFile($import) {
        $allRows = $import->getErrors();
        $errorFile = 'errors_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
        $errorFilePath = 'public/' . $errorFile;

        Excel::store(new ContactError($allRows), $errorFilePath);
        $errorFileUrl = Storage::url($errorFilePath);

        return $errorFileUrl;
    }

    public function categoryGenerator() {
        foreach (Contact::cursor() as $contact) {
            yield [
                'name'      => $contact->name,
                'email'     => $contact->email,
                'phone'     => $contact->phone,
                'details'   => $contact->details
            ];
        }
    }
}
