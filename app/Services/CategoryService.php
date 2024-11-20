<?php

namespace App\Services;

use App\Models\Category;

class CategoryService extends BaseService
{
    public function getModel(): Category
    {
        return new Category();
    }

    public function getAll()
    {
        return Category::ofAccount()->with('children')->get();
    }
}