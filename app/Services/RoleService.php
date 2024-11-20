<?php

namespace App\Services;

use App\Models\Role;

class RoleService extends BaseService
{
    public function getModel()
    {
        return $this->model ?? new Role();
    }
}