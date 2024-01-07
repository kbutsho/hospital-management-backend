<?php

namespace Database\Seeders;

use App\Models\DoctorFee;
use Illuminate\Database\Seeder;

class DoctorFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            ['doctor_id' => 1, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 2, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 4, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 5, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 6, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 7, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 8, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 9, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 10, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 11, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 12, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 13, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 14, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 15, 'fee' => 1000, 'created_at' => now(), 'updated_at' => now()],
        ];
        DoctorFee::insert($fees);
    }
}
