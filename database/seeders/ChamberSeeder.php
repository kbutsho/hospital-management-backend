<?php

namespace Database\Seeders;

use App\Helpers\STATUS;
use App\Models\Chamber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChamberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chambers = [
            ['room' => 'DN011', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN012', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN013', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN014', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS011', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS012', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS013', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS014', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN021', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN022', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN023', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DN024', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS021', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS023', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS023', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['room' => 'DS024', 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()]
        ];
        Chamber::insert($chambers);
    }
}
