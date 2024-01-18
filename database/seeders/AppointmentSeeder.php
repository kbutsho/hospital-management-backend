<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = [
            ['serial_id' => 1, 'serial_number' => 1, 'patient_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];
        Appointment::insert($appointments);
    }
}
