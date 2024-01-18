<?php

namespace Database\Seeders;

use App\Models\Assistant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssistantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctor = [
            ['user_id' => 17, 'name' => 'AS. SUSHMITA ROY', 'address' => "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'female', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 18, 'name' => 'AS. ISHITA DATTA', 'address' => "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'female', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 19, 'name' => 'AS. PRIYA ADHIKARY', 'address' => "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'female', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 20, 'name' => 'AS. LITON AHMED', 'address' =>  "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'male', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 21, 'name' => 'AS. SHEKH HABIB', 'address' =>  "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'male', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 22, 'name' => 'AS. DIPANKAR MITRA', 'address' =>  "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'male', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 23, 'name' => 'AS. DIPTA SAHA', 'address' => "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'female',  'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 24, 'name' => 'AS. ZANNAT RAKHI', 'address' =>  "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'female', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 25, 'name' => 'AS. PARAG GHOSH', 'address' =>  "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'male', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 26, 'name' => 'AS. KAUSHIK BISWAS', 'address' =>  "Bashundhara R/A, Block:G, Road:07, House: 771", 'age' => 25, 'gender' => 'male', 'created_at' => now(), 'updated_at' => now()],
        ];
        Assistant::insert($doctor);
    }
}
