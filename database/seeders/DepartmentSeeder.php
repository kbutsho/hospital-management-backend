<?php

namespace Database\Seeders;

use App\Helpers\STATUS;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = [
            ['name' => 'Cardiology', 'description' => 'The Orthopedics department focuses on the diagnosis and treatment of musculoskeletal disorders, including fractures, arthritis, sports injuries, and spinal conditions.', 'photo' => '1.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Orthopedics', 'description' => 'The Orthopedics department focuses on the diagnosis and treatment of musculoskeletal disorders, including fractures, arthritis, sports injuries, and spinal conditions.', 'photo' => '2.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Neurology', 'description' => 'The Neurology department specializes in the diagnosis and treatment of disorders of the nervous system, including conditions affecting the brain, spinal cord, and nerves.', 'photo' => '3.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pediatrics', 'description' => 'The Pediatrics department provides medical care for infants, children, and adolescents, addressing a wide range of health issues from routine check-ups to complex medical conditions.', 'photo' => '4.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dermatology', 'description' => 'The Dermatology department focuses on the diagnosis and treatment of skin, hair, and nail conditions, including acne, eczema, psoriasis, and skin cancer.', 'photo' => '5.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ophthalmology', 'description' => 'The Ophthalmology department specializes in the diagnosis and treatment of eye diseases and disorders, including cataracts, glaucoma, and refractive errors.', 'photo' => '6.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Geriatrics', 'description' => 'The Geriatrics department provides specialized care for elderly patients, focusing on the unique health concerns and needs associated with aging.', 'photo' => '7.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urology', 'description' => 'The Urology department deals with the diagnosis and treatment of disorders of the urinary tract system in both males and females, as well as the male reproductive system.', 'photo' => '8.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hematology', 'description' => "Hematology focuses on diagnosing and treating disorders of the blood, such as anemia, leukemia, and clotting abnormalities, through specialized testing and therapies", 'photo' => '9.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ENT', 'description' => 'The Ear, Nose, and Throat (ENT) department specializes in the diagnosis and treatment of conditions affecting the ears, nose, throat, and related structures.', 'photo' => '10.png', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()]
        ];
        Department::insert($department);
    }
}