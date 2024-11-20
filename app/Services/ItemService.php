<?php

namespace App\Services;

use App\Models\Item;

class ItemService extends BaseService
{
    public function getModel(): Item
    {
        return new Item();
    }

    public function store(array $data)
    {
        if (isset($data['photo'])) {
            $filename = $this->getModel()->uploadFile($data['photo']); 
            $data['photo'] = $filename;  
        }
        else {
            unset($data['photo']);
        }
        if (!isset($data['has_variants']) && isset($data['variants'])) {
            unset($data['variants']);
        }

        $this->save([
            ...$data,
            'account_id' => auth()->user()->account_id ?? auth()->user()->id,
        ])->addVariations()->saveRelations($data);
    }

    public function getAll(array $filters = null, array $relations = ['unit', 'category'], bool $hasPaginate = true)
    {
        $query = $this->getModel()::query();

        $query = $query->filters($filters);
        
        $query = $query->with($relations)->orderByDesc('id');

         return $query->paginate();
    }

    public function update(array $data, Item $item)
    {
        if ($data['photo_removed'] == 1) {
            $item->deleteFile($item->photo);
            $data['photo'] = null;  
        }
        if (isset($data['photo'])) {
            $item->deleteFile($item->photo);
            $photo = $item->uploadFile($data['photo']);
            $data['photo'] = $photo;
        }
        if (!isset($data['has_variants']) && isset($data['variants'])) {
            unset($data['variants']);
        }
        if(isset($data['has_variants']) && !isset($data['variants'])) {
            $data['variants'] = [];
        }
        if(!isset($data['has_variants'])){
            $data['has_variants'] = 0;
        }
        
        $item->update([
            ...$data,
            'track_weight'      => $data['track_weight'] ?? 0,
            'track_quantity'    => $data['track_quantity'] ?? 0,
        ]);
        $item->addVariations()->saveRelations($data);

        return true;
    }

    public function destroy(Item $item, bool $forceDelete = false): bool
    {
        if ($forceDelete) {
            $item->deleteFile($item->photo);
            return $item->forceDelete();
        }
        return $item->del();
    }
}