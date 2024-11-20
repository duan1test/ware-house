<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;

trait Authorizable
{
    private $abilities = [
        'index'               => 'read',
        'show'                => 'read',
        'edit'                => 'update',
        'update'              => 'update',
        'create'              => 'create',
        'store'               => 'create',
        'destroy'             => 'delete',
        'import'              => 'import',
    ];
    private $allowed = [
        'read-dashboard',
        'read-profile',
        'update-profile',
    ];
    private $disabled = [
        'update-users',
        'update-roles',
        'delete-users',
        'delete-roles',
    ];

    public function callAction($method, $parameters)
    {
        $ability = $this->getAbility($method);
        if ($ability && !Str::contains($ability, 'search')) {
            if (!in_array($ability, $this->allowed)) {
                $this->authorize($ability);
            }
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        $routeName = explode('.', Request::route()->getName());
        
        $action = Arr::get($this->getAbilities(), Str::kebab($method));
        return $action ? Str::kebab($action . '-' . $routeName[0]) : null;
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }

    private function getAbilities()
    {
        return $this->abilities;
    }
}
