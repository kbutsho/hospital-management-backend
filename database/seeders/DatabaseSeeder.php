<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AdministratorSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(DoctorFeeSeeder::class);
        $this->call(ChamberSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(SerialSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(AssistantSeeder::class);
        $this->call(AssignedAssistantSeeder::class);
        // $this->call(PrescriptionSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
