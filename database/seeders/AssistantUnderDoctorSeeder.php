<?php

namespace Database\Seeders;

use App\Models\AssistantUnderDoctor;
use Illuminate\Database\Seeder;

class AssistantUnderDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assistantUnderDoctor = [
            ['assistant_id' => 1, 'doctor_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 2, 'doctor_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 3, 'doctor_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 4, 'doctor_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 5, 'doctor_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 6, 'doctor_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 7, 'doctor_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 8, 'doctor_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 9, 'doctor_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 10, 'doctor_id' => 10, 'created_at' => now(), 'updated_at' => now()]
        ];
        AssistantUnderDoctor::insert($assistantUnderDoctor);
    }
}
