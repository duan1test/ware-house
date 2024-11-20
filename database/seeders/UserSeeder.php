<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        $user = [
            'name'              => 'ADMIN',
            'email'             => 'super.admin@admin.com',
            'username'          => 'superadmin',
            'password'          => 'admin',
            'view_all'          => true,
            'edit_all'          => true,
            'warehouse_id'      => 1,
            'account_id'        => 1,
            'extra_attributes'  => json_encode(['attribute1' => 'value1', 'attribute2' => 'value2']),
        ];

        User::create($user);
    }
}
