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
            ['name' => 'KALPANA RANY GHOSH', 'age' => 53, 'address' => 'LAXMIPASHA, LOHAGARA, NARAIL', 'phone' => '01718851072', 'created_at' => now(), 'updated_at' => now()]
        ];
        Patient::insert($patients);
    }
}
