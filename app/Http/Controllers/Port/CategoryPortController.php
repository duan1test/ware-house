<?php

namespace App\Http\Controllers\Port;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use App\Exports\CategoryError;
use App\Imports\CategoryImport;
use App\Http\Requests\ImportRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class CategoryPortController extends Controller
{
    public function import() {
        return view('pages.category.import');
    }

    public function export() {
        return Excel::download(new CategoryExport($this->categoryGenerator()), 'categories.xlsx');
    }
    public function save(ImportRequest $request) {
        try {
            $import = new CategoryImport();
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

            return redirect()->route('categories.index')->with('success', __('messages.import.success', [
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

        Excel::store(new CategoryError($allRows), $errorFilePath);
        $errorFileUrl = Storage::url($errorFilePath);

        return $errorFileUrl;
    }

    public function categoryGenerator() {
        foreach (Category::cursor() as $category) {
            $parentCode = $category->parent_id ? Category::find($category->parent_id)->code : '';

            yield [
                'code' => $category->code,
                'name' => $category->name,
                'parent' => $parentCode
            ];
        }
    }
}
