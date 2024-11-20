<?php

namespace App\Http\Controllers\Port;


use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UnitError;
use App\Exports\UnitExport;
use App\Http\Requests\ImportRequest;
use App\Imports\UnitImport;
use App\Models\Unit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UnitPortController extends Controller
{
    public function import() {
        return view('pages.unit.import');
    }

    public function export() {
         return Excel::download(new UnitExport($this->categoryGenerator()), 'units.xlsx');
    }
    public function save(ImportRequest $request) {
        try {
            $import = new UnitImport();
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

            return redirect()->route('units.index')->with('success', __('messages.import.success', [
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

        Excel::store(new UnitError($allRows), $errorFilePath);
        $errorFileUrl = Storage::url($errorFilePath);

        return $errorFileUrl;
    }

    public function categoryGenerator() {
        foreach (Unit::cursor() as $unit) {
            yield [
                'name'              => $unit->name,
                'code'              => $unit->code,
                'base_unit'         => $unit->baseUnit != null?$unit->baseUnit->code:'',
                'operator'          => $unit->operator,
                'operation_value'   => $unit->operation_value
            ];
        }
    }
}
