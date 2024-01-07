<?php

namespace Database\Seeders;

use App\Helpers\STATUS;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = [
            ['name' => 'Cardiology', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Orthopedics', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Neurology', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pediatrics', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dermatology', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ophthalmology', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Geriatrics', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urology', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hematology', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ENT', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()]
        ];
        Department::insert($department);
    }
}
