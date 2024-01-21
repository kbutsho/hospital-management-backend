<?php

namespace Database\Seeders;

use App\Models\DoctorsFee;
use Illuminate\Database\Seeder;

class DoctorFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            ['doctor_id' => 1, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 2, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 4, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 5, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 6, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 7, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 8, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 9, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 10, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 11, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 12, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 13, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 14, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 15, 'fees' => 1000, 'created_at' => now(), 'updated_at' => now()],
        ];
        DoctorsFee::insert($fees);
    }
}