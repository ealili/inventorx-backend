<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => Role::ADMIN_ROLE_ID,
                'name' => 'Admin'
            ],
            [
                'id' => Role::USER_ROLE_ID,
                'name' => 'User'
            ]
        ]);
    }
}
