<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            'users' => [
                'read', 'create', 'update', 'delete'
            ],
            'roles' => [
                'read', 'create', 'update', 'delete'
            ],
            'warehouses' => [
                'read', 'create', 'update', 'delete', 'import'
            ],
            'categories' => [
                'read', 'create', 'update', 'delete', 'import'
            ],
            'items' => [
                'read', 'create', 'update', 'delete', 'import'
            ],
            'transfers' => [
                'read', 'create', 'update', 'delete'
            ],
            'adjustments' => [
                'read', 'create', 'update', 'delete'
            ],
            'checkins' => [
                'read', 'create', 'update', 'delete'
            ],
            'checkouts' => [
                'read', 'create', 'update', 'delete'
            ],
            'units' => [
                'read', 'create', 'update', 'delete', 'import'
            ],
            'contacts' => [
                'read', 'create', 'update', 'delete', 'import'
            ],
            'reports' => [
                'read'
            ],
            
        ];

        $role = Role::create([
            'name' => 'admin',
            'account_id' => '1'
        ]);
        Role::create([
            'name' => 'Super Admin',
            'account_id' => '1'
        ]);

        foreach ($permissions as $key => $permission) {
            foreach($permission as $val) {
                $permissionRole = Permission::create(['name' => $val . '-' . $key]);
                $permissionRole->assignRole($role);
            }
        }
        
        $user = User::find(1);
        $user->assignRole('Super Admin');
    }
}
