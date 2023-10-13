<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project_statuses')->insert(
            [
                ['status' => 'Pending'],
                ['status' => 'Ongoing'],
                ['status' => 'Finished'],
            ]);
    }
}
