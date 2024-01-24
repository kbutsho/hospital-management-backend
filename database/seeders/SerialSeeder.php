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
            ['name' => 'KALPANA GHOSH', 'phone' => '01718851001', 'age' => 53, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 1, 'doctor_id' => 1, 'department_id' => 1, 'date' => date('2024-02-03'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'KAUSHIK BISWAS', 'phone' => '01718851002', 'age' => 25, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 1, 'doctor_id' => 1, 'department_id' => 1, 'date' => date('2024-02-03'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MD RIYAD', 'phone' => '01718851003', 'age' => 23, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 1, 'doctor_id' => 1, 'department_id' => 1, 'date' => date('2024-02-03'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'PRIYA ROY', 'phone' => '01718851004', 'age' => 43, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 9, 'doctor_id' => 2, 'department_id' => 2, 'date' => date('2024-01-25'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ZANNAT RAKHI', 'phone' => '01718851005', 'age' => 23, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 9, 'doctor_id' => 2, 'department_id' => 2, 'date' => date('2024-01-25'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'RITU SAHA', 'phone' => '01718851006', 'age' => 23, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 11, 'doctor_id' => 3, 'department_id' => 3, 'date' => date('2024-01-27'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PARAG GHOSH', 'phone' => '01718851007', 'age' => 26, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 11, 'doctor_id' => 3, 'department_id' => 3, 'date' => date('2024-01-27'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TANVIR KADER', 'phone' => '01718851008', 'age' => 22, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 11, 'doctor_id' => 3, 'department_id' => 3, 'date' => date('2024-01-27'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MD RIFAT', 'phone' => '017188510709', 'age' => 21, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 11, 'doctor_id' => 3, 'department_id' => 3, 'date' => date('2024-01-27'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'BRISTY SAHA', 'phone' => '01718851010', 'age' => 32, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OISHI ROY', 'phone' => '01718851011', 'age' => 21, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ANINDITA BISWAS', 'phone' => '01718851012', 'age' => 33, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MEHEDI HASAN', 'phone' => '01718851013', 'age' => 51, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],

            // unpaid, not patient, not appointment
            ['name' => 'MISHAL AHMED', 'phone' => '01718851014', 'age' => 53, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'unpaid', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'KAWSAR AHMED', 'phone' => '01718851015', 'age' => 21, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'unpaid', 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'MD RIYAD', 'phone' => '01718851003', 'age' => 23, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'schedule_id' => 24, 'doctor_id' => 4, 'department_id' => 4, 'date' => date('2024-01-26'), 'payment_status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
        ];
        Serial::insert($serials);
    }
}
