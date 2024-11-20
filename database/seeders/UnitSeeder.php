<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->truncate();

        Unit::insert([
            [
                'name' => 'Meter',
                'code' => 'met'
            ],
            [
                'name' => 'Kilogram',
                'code' => 'kg'
            ],
            [
                'name' => 'Piece',
                'code' => 'pc'
            ],
        ]);
    }
}
