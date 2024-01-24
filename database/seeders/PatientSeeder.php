<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            ['name' => 'KALPANA GHOSH', 'phone' => '01718851001', 'age' => 53, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'KAUSHIK BISWAS', 'phone' => '01718851002', 'age' => 25, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MD RIYAD', 'phone' => '01718851003', 'age' => 23, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PRIYA ROY', 'phone' => '01718851004', 'age' => 43, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RITU SAHA', 'phone' => '01718851006', 'age' => 23, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PARAG GHOSH', 'phone' => '01718851007', 'age' => 26, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TANVIR KADER', 'phone' => '01718851008', 'age' => 22, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MD RIFAT', 'phone' => '017188510709', 'age' => 21, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'BRISTY SAHA', 'phone' => '01718851010', 'age' => 32, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OISHI ROY', 'phone' => '01718851011', 'age' => 21, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ANINDITA BISWAS', 'phone' => '01718851012', 'age' => 33, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MEHEDI HASAN', 'phone' => '01718851013', 'age' => 51, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'created_at' => now(), 'updated_at' => now()]
        ];
        Patient::insert($patients);
    }
}
