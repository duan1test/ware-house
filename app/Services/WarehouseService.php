<?php

namespace App\Services;

use App\Models\Warehouse;

class WarehouseService extends BaseService {

    public function __construct()
    {
    }

    public function getModel()
    {
        return new Warehouse();
    }
    
    public function store(array $data)
    {
        if (isset($data['logo'])) {
            $filePath = $data['logo']->store(Warehouse::FOLDER_IMAGE, 'public');
            $data['logo'] = $filePath;
        }
        
        return $this->save($data);
    }

    public function update(array $validatedData = [], object $warehouse) 
    {
        if ($validatedData['photo_removed'] == 1) {
            if ($warehouse->logo) {
                \Storage::disk('public')->delete($warehouse->logo);
            }
            $validatedData['logo'] = null;  
        }

        if (isset($validatedData['logo'])) {
            if ($warehouse->logo) {
                \Storage::disk('public')->delete($warehouse->logo);
            }

            $filePath = $validatedData['logo']->store(Warehouse::FOLDER_IMAGE, 'public');
            $validatedData['logo'] = $filePath;
        }

        $warehouse->update($validatedData);

        return $warehouse;
    }

    public function getActiveOfAccount()
    {
        return $this->getModel()->ofAccount(auth()->user()->account_id ?? auth()->user()->id)->active()->get();
    }
}