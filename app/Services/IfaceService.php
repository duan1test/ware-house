<?php 

namespace App\Services;

use Illuminate\Support\Facades\File;

interface IfaceService {
    public function getModel();
    
    public function getAll();

    public function getById(string $id);

    public function getByAttribute(array $attribute, string $expression);

    public function save(array $data, string $id);

    public function delete(string $id);

    public function getByIds(array $ids);
}