<?php

namespace Database\Seeders;

use App\Models\Serial;
use Illuminate\Database\Seeder;

class SerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serials = [
            ['name' => 'KALPANA RANY GHOSH', 'phone' => '01718851072', 'age' => 53, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 20, 'doctor_id' => 3, 'department_id' => 2, 'date' => date('2024-01-23'), 'payment_status' => 'unpaid', 'created_at' => now(), 'updated_at' => now()]
        ];
        Serial::insert($serials);
    }
}
