<?php

namespace App\Services;

use App\Models\Permission;

class PermissionService extends BaseService
{
    public function getModel()
    {
        return $this->model ?? new Permission();
    }
}