<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = [
            ['user_id' => 1, 'name' => 'KAUSHIK BISWAS', 'address' => 'LAXMIPASHA, LOHAGARA, LAXMIPASHA - 7510, NARAIL', 'age' => 25, 'gender' => 'male',  'created_at' => now(), 'updated_at' => now()],
        ];
        Administrator::insert($administrator);
    }
}
