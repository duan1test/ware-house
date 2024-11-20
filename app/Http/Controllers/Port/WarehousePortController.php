<?php

namespace App\Http\Controllers\Port;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Exports\WarehouseEroror;
use App\Exports\WarehouseExport;
use App\Imports\WarehouseImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class WarehousePortController extends Controller
{
    public function import() {
        return view('pages.warehouse.import');
    }

    public function export() {
        return Excel::download(new WarehouseExport($this->warehouseGenerator()), 'warehouses.xlsx');
    }
    public function save(ImportRequest $request)
    {
        try {
            $import = new WarehouseImport();
            Excel::import($import, $request->validated()['excel']);

            $errors = $import->getErrors();
            $addedCount = $import->getAddedCount();
            $updatedCount = $import->getUpdatedCount();
            
            if(!empty($errors)) {
                $errorFileUrl = $this->handleErrorFile($import);
                return redirect()->back()->with([
                    'error'     =>  __('messages.import.error'),
                    'download'  => $errorFileUrl,
                ]);
            }

            return redirect()->route('warehouses.index')->with('success', __('messages.import.success', [
                'added' => $addedCount,
                'updated' => $updatedCount,
            ]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with([
                'error'     =>  __('messages.import.error')
            ]);
        }
    }

    public function handleErrorFile($import)
    {
        $allRows = $import->getErrors();
        $errorFile = 'errors_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
        $errorFilePath = 'public/' . $errorFile;

        Excel::store(new WarehouseEroror($allRows), $errorFilePath);
        $errorFileUrl = Storage::url($errorFilePath);

        return $errorFileUrl;
    }

    private function warehouseGenerator()
    {
        foreach (Warehouse::cursor() as $warehouse) {
            yield [
                'code'    => $warehouse->code,
                'name'    => $warehouse->name,
                'email'   => $warehouse->email,
                'phone'   => $warehouse->phone,
                'address' => $warehouse->address,
                'active'  => $warehouse->active == 1 ? 'yes' : 'no',
            ];
        }
    }
}
