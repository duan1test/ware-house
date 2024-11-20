<?php

namespace App\Http\Controllers\Port;

use App\Exports\ItemError;
use App\Exports\ItemExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemImport;
use App\Http\Requests\ImportRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;

class ItemPortController extends Controller
{
    public function import() {
        return view('pages.item.import');
    }

    public function export() {
        return Excel::download(new ItemExport($this->itemGenerator()), 'items.xlsx');
    }

    public function save(ImportRequest $request) {
        try {
            $import = new ItemImport();
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

            return redirect()->route('items.index')->with('success', __('messages.import.success', [
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

        Excel::store(new ItemError($allRows), $errorFilePath);
        $errorFileUrl = Storage::url($errorFilePath);

        return $errorFileUrl;
    }

    public function itemGenerator() {
        foreach (Item::cursor() as $item) {
            $variantsFormatted = '';
            if (!empty($item->variants)) {
                $variantArray = $item->variants;
    
                $variantParts = array_map(function($variant) {
                    return $variant['name'] . '=' . implode(',', $variant['option']);
                }, $variantArray);
    
                $variantsFormatted = implode('|', $variantParts);
            }
    
            yield [
                'name' => $item->name,
                'code' => $item->code,
                'sku' => $item->sku,
                'symbology' => $item->symbology ?? 'CODE128',
                'unit' => $item->unit->code ?? '',
                'categories' => $item->category->code ?? '',
                'details' => $item->details,
                'has_serials' => $item->has_serials ? 'yes' : '',
                'track_weight' => $item->track_weight ? 'yes' : '',
                'track_quantity' => $item->track_quantity ? 'yes' : '',
                'alert_quantity' => (string) $item->alert_quantity ? number_format($item->alert_quantity, 2, '.', '') : '',
                'has_variants' => $item->has_variants ? 'yes' : '',
                'variants' => $variantsFormatted ?? '',
                'rack_location' => $item->rack_location,
            ];
        }
    }
}
