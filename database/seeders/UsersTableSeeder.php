<?php

namespace Database\Seeders;

use App\Helpers\ROLE;
use App\Helpers\STATUS;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // administrator
            ['phone' => '017149555000', 'email' => 'kbutsho@gmail.com', 'role' => ROLE::ADMINISTRATOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            // doctor
            ['phone' => '017149555001', 'email' => 'dr.hasnat@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555002', 'email' => 'dr.rima@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555003', 'email' => 'dr.subrata@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555004', 'email' => 'dr.partho@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555005', 'email' => 'dr.sushmita@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555006', 'email' => 'dr.ishita@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555007', 'email' => 'dr.priya@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555008', 'email' => 'dr.liton@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555009', 'email' => 'dr.habib@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555010', 'email' => 'dr.dipankar@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555011', 'email' => 'dr.dipta@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555012', 'email' => 'dr.rakhi@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555013', 'email' => 'dr.parag@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555014', 'email' => 'dr.kaushik@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555015', 'email' => 'dr.ritu@gmail.com', 'role' => ROLE::DOCTOR, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],


            // assistant
            ['phone' => '017149555016', 'email' => 'as.sushmita@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555017', 'email' => 'as.ishita@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555018', 'email' => 'as.priya@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555019', 'email' => 'as.liton@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555020', 'email' => 'as.habib@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555021', 'email' => 'as.dipankar@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555022', 'email' => 'as.dipta@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555023', 'email' => 'as.rakhi@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555024', 'email' => 'as.parag@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '017149555025', 'email' => 'as.kaushik@gmail.com', 'role' => ROLE::ASSISTANT, 'status' => STATUS::ACTIVE, 'password' => Hash::make('Hospital@1234'), 'created_at' => now(), 'updated_at' => now()]
        ];
        User::insert($users);
    }
}
