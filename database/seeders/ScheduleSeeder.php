<?php

namespace Database\Seeders;

use App\Helpers\STATUS;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'saturday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(12, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'saturday', 'opening_time' => Carbon::createFromTime(14, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'sunday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(12, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'sunday', 'opening_time' => Carbon::createFromTime(14, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'thursday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(12, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'thursday', 'opening_time' => Carbon::createFromTime(14, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(12, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 1, 'chamber_id' => 1, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(14, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],


            ['doctor_id' => 2, 'chamber_id' => 2, 'day' => 'thursday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 2, 'chamber_id' => 2, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],

            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'saturday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'saturday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'sunday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'sunday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'monday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'monday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'tuesday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'tuesday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'wednesday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'wednesday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'thursday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 3, 'chamber_id' => 3, 'day' => 'thursday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],

            ['doctor_id' => 4, 'chamber_id' => 4, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(10, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 4, 'chamber_id' => 4, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],

            ['doctor_id' => 5, 'chamber_id' => 4, 'day' => 'saturday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 5, 'chamber_id' => 4, 'day' => 'saturday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],

            ['doctor_id' => 6, 'chamber_id' => 5, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(8, 0, 0), 'closing_time' => Carbon::createFromTime(14, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 7, 'chamber_id' => 5, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(21, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],

            ['doctor_id' => 8, 'chamber_id' => 6, 'day' => 'monday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 8, 'chamber_id' => 6, 'day' => 'thursday', 'opening_time' => Carbon::createFromTime(17, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],

            ['doctor_id' => 9, 'chamber_id' => 6, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 10, 'chamber_id' => 7, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 11, 'chamber_id' => 8, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 12, 'chamber_id' => 9, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 13, 'chamber_id' => 10, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 14, 'chamber_id' => 11, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
            ['doctor_id' => 15, 'chamber_id' => 12, 'day' => 'friday', 'opening_time' => Carbon::createFromTime(9, 0, 0), 'closing_time' => Carbon::createFromTime(17, 0, 0), 'status' => STATUS::ACTIVE, 'created_at' => now(), 'updated_at' => now()],
        ];
        Schedule::insert($schedules);
    }
}
