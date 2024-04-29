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
            ['serial_id' => 1, 'schedule_id' => 1, 'patient_id' => 1, 'serial_number' => 1, 'status' => 'closed', 'date' => date('2024-02-03'),  'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 2, 'schedule_id' => 1, 'patient_id' => 2, 'serial_number' => 2, 'status' => 'closed', 'date' => date('2024-02-03'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 3, 'schedule_id' => 1, 'patient_id' => 3, 'serial_number' => 3, 'status' => 'paid', 'date' => date('2024-02-03'), 'created_at' => now(), 'updated_at' => now()],

            ['serial_id' => 4, 'schedule_id' => 9, 'patient_id' => 4, 'serial_number' => 1, 'status' => 'paid', 'date' => date('2024-01-25'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 5, 'schedule_id' => 9, 'patient_id' => 5, 'serial_number' => 2, 'status' => 'paid', 'date' => date('2024-01-25'), 'created_at' => now(), 'updated_at' => now()],

            ['serial_id' => 6, 'schedule_id' => 11, 'patient_id' => 6, 'serial_number' => 1, 'status' => 'paid', 'date' => date('2024-01-27'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 7, 'schedule_id' => 11, 'patient_id' => 7, 'serial_number' => 2, 'status' => 'paid', 'date' => date('2024-01-27'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 8, 'schedule_id' => 11, 'patient_id' => 8, 'serial_number' => 3, 'status' => 'paid', 'date' => date('2024-01-27'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 9, 'schedule_id' => 11, 'patient_id' => 9, 'serial_number' => 4, 'status' => 'paid', 'date' => date('2024-01-27'), 'created_at' => now(), 'updated_at' => now()],

            ['serial_id' => 10, 'schedule_id' => 24, 'patient_id' => 10, 'serial_number' => 1, 'status' => 'paid', 'date' => date('2024-01-26'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 11, 'schedule_id' => 24, 'patient_id' => 11, 'serial_number' => 2, 'status' => 'paid', 'date' => date('2024-01-26'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 12, 'schedule_id' => 24, 'patient_id' => 12, 'serial_number' => 3, 'status' => 'paid', 'date' => date('2024-01-26'), 'created_at' => now(), 'updated_at' => now()],
            ['serial_id' => 13, 'schedule_id' => 24, 'patient_id' => 13, 'serial_number' => 4, 'status' => 'paid', 'date' => date('2024-01-26'), 'created_at' => now(), 'updated_at' => now()],

            // ['serial_id' => 14, 'schedule_id' => 24, 'patient_id' => 14, 'serial_number' => 5, 'status' => 'unpaid',  'created_at' => now(), 'updated_at' => now()],
            // ['serial_id' => 15, 'schedule_id' => 24, 'patient_id' => 15, 'serial_number' => 6, 'status' => 'unpaid',  'created_at' => now(), 'updated_at' => now()],

            ['serial_id' => 16, 'schedule_id' => 24, 'patient_id' => 3, 'serial_number' => 5, 'status' => 'paid', 'date' => date('2024-01-26'), 'created_at' => now(), 'updated_at' => now()],
        ];
        Appointment::insert($appointments);
    }
}
