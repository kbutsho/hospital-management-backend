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
            ['user_id' => 2, 'bmdc_id' => '34587/44191/01', 'name' => 'PROF. DR. HASNAT RAHMAN', 'photo' => '2.jpeg', 'department_id' => 1, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'bmdc_id' => '34587/44191/02', 'name' => 'PROF. DR. RIMA SEN', 'photo' => '1.jpeg', 'department_id' => 2, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'bmdc_id' => '34587/44191/03', 'name' => 'PROF. DR. SUBRATA GHOSH', 'photo' => '3.jpeg', 'department_id' => 2, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'bmdc_id' => '34587/44191/04', 'name' => 'PROF. DR. PARTHO BISWAS', 'photo' => '4.jpeg', 'department_id' => 3, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'bmdc_id' => '34587/44191/05', 'name' => 'PROF. DR. SUSHMITA ROY', 'photo' => '1.jpeg', 'department_id' => 3, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 7, 'bmdc_id' => '34587/44191/06', 'name' => 'PROF. DR. ISHITA DATTA', 'photo' => '1.jpeg', 'department_id' => 3, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'bmdc_id' => '34587/44191/07', 'name' => 'PROF. DR. PRIYA ADHIKARY', 'photo' => '1.jpeg', 'department_id' => 4, 'designation' => 'MBBS BCS(Health)', 'address' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'bmdc_id' => '34587/44191/08', 'name' => 'PROF. DR. LITON AHMED', 'photo' => '5.jpeg', 'department_id' => 5, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'bmdc_id' => '34587/44191/09', 'name' => 'PROF. DR. SHEKH HABIB', 'photo' => '6.jpeg', 'department_id' => 5, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 11, 'bmdc_id' => '34587/44191/10', 'name' => 'PROF. DR. DIPANKAR MITRA', 'photo' => '7.jpeg', 'department_id' => 6, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 12, 'bmdc_id' => '34587/44191/11', 'name' => 'PROF. DR. DIPTA SAHA', 'photo' => '1.jpeg', 'department_id' => 7, 'designation' => 'MBBS BCS(Health)', 'address' => null,  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 13, 'bmdc_id' => '34587/44191/12', 'name' => 'PROF. DR. ZANNAT RAKHI', 'photo' => '1.jpeg', 'department_id' => 8, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 14, 'bmdc_id' => '34587/44191/13', 'name' => 'PROF. DR. PARAG GHOSH', 'photo' => '8.jpeg', 'department_id' => 9, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 15, 'bmdc_id' => '34587/44191/14', 'name' => 'PROF. DR. KAUSHIK BISWAS', 'photo' => '2.jpeg', 'department_id' => 9, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 16, 'bmdc_id' => '34587/44191/15', 'name' => 'PROF. DR. RITU SAHA', 'photo' => '1.jpeg', 'department_id' => 10, 'designation' => 'MBBS BCS(Health)', 'address' =>  null, 'created_at' => now(), 'updated_at' => now()],
        ];
        Doctor::insert($doctor);
    }
}
