<?php

namespace App\Services;

use App\Models\Contact;

class ContactService extends BaseService
{
    public function getModel()
    {
        return $this->model ?? new Contact();
    }

    public function getAll(array $filters = [])
    {
        $query = $this->getModel()::query();

        $query = $query->filters($filters);
        $query = $query->orderBy('id', 'desc')->paginate();

        return $query;
    }
}