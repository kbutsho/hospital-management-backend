<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctor = [
            ['user_id' => 2, 'bmdc_id' => '34587/44191/01', 'name' => 'DR. HASNAT RAHMAN',  'department_id' => 1, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'bmdc_id' => '34587/44191/02', 'name' => 'DR. RIMA SEN',  'department_id' => 2, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'bmdc_id' => '34587/44191/03', 'name' => 'DR. SUBRATA GHOSH',  'department_id' => 2, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'bmdc_id' => '34587/44191/04', 'name' => 'DR. PARTHO BISWAS',  'department_id' => 3, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'bmdc_id' => '34587/44191/05', 'name' => 'DR. SUSHMITA ROY',  'department_id' => 3, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 7, 'bmdc_id' => '34587/44191/06', 'name' => 'DR. ISHITA DATTA',  'department_id' => 3, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'bmdc_id' => '34587/44191/07', 'name' => 'DR. PRIYA ADHIKARY',  'department_id' => 4, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'bmdc_id' => '34587/44191/08', 'name' => 'DR. LITON AHMED',  'department_id' => 5, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'bmdc_id' => '34587/44191/09', 'name' => 'DR. SHEKH HABIB',  'department_id' => 5, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'bmdc_id' => '34587/44191/10', 'name' => 'DR. DIPANKAR MITRA',  'department_id' => 6, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 12, 'bmdc_id' => '34587/44191/11', 'name' => 'DR. DIPTA SAHA',  'department_id' => 7, 'designation' => 'MBBS BCS(Health)', 'address' => null,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 13, 'bmdc_id' => '34587/44191/12', 'name' => 'DR. ZANNAT RAKHI',  'department_id' => 8, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 14, 'bmdc_id' => '34587/44191/13', 'name' => 'DR. PARAG GHOSH',  'department_id' => 9, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 15, 'bmdc_id' => '34587/44191/14', 'name' => 'DR. KAUSHIK BISWAS',  'department_id' => 9, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 16, 'bmdc_id' => '34587/44191/15', 'name' => 'DR. RITU SAHA',  'department_id' => 10, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
        ];
        Doctor::insert($doctor);
    }
}
