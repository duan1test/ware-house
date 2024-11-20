<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService
{
    public function getModel()
    {
        return $this->model ?? new User();
    }

    public function getAll(array $filters = null)
    {
        $query = $this->getModel()::query();

        if ($filters['search']) {
            $query = $this->getModel()::search($filters['search']);
        }

        $query->when($filters['trashed'],function($query) use ($filters){
            $query = $query->filterTrash($filters['trashed']);
        });

        $query = $query->orderByDesc('id');

        return $query->paginate();
    }
}