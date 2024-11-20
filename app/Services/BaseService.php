<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Services\Admin\FileUploadService;
use Illuminate\Support\Facades\Storage;

abstract class BaseService implements IfaceService {

    protected $model;
    protected $fileUploadService;

    abstract public function getModel();

    public function getById($id)
    {
        $result = $this->getModel()->find($id);
        if(empty($result)) {
            throw new Exception(__('common.messages.not_found'));
        }
        
        return $result;
    }

    public function save($data, $id = null)
    {
        if($id == null) {
            $result = $this->getModel()->fill($data);
        } else {
            $result = $this->getById($id);
            $result->fill($data);
        }
        $result->save();
        
        return $result;
    }

    public function delete($id)
    {
        $instance = $this->getById($id);
        if(!is_null($instance)) {
            $instance->delete();
        }
        
        return true;
    }

    public function getAll()
    {
        return $this->getModel()->all();
    }

    public function getByAttribute($attribute, $expression = '=', $relation = [])
    {
        $condition = [];
        foreach($attribute as $key => $value) {
            $condition[] = [$key, $expression, $value];
        }

        if(!empty($relation)) {
            return $this->model->where($condition)->with($relation)->get();
        }

        return $this->getModel()->where($condition)->get();
    }

    public function getByIds(array $ids)
    {
        return $this->getModel()->whereIn('id', $ids)->get();
    }
}