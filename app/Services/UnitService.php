<?php

namespace App\Services;

use App\Models\Unit;

class UnitService extends BaseService
{
    public function getModel(): Unit
    {
        if (!$this->model) {
            $this->model = new Unit();
        }
        return $this->model;
    }

    public function getBaseUnit()
    {
        return $this->getModel()->where('base_unit_id', null)->get();
    }
}