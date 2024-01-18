<?php

namespace Database\Seeders;

use App\Models\AssignedAssistant;
use Illuminate\Database\Seeder;

class AssignedAssistantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignedAssistants = [
            ['assistant_id' => 1, 'chamber_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 2, 'chamber_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 3, 'chamber_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 4, 'chamber_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 5, 'chamber_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 6, 'chamber_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 7, 'chamber_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 8, 'chamber_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 9, 'chamber_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['assistant_id' => 10, 'chamber_id' => 10, 'created_at' => now(), 'updated_at' => now()]
        ];
        AssignedAssistant::insert($assignedAssistants);
    }
}
