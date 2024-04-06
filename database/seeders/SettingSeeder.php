<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['organization_name' => 'Apollo Hospital', 'address' => 'Greams Lane, 21, Greams Rd, Thousand Lights, Chennai, Tamil Nadu 600006, India', 'phone' => '+8801749555864', 'email' => 'kbutsho@gmail.com', 'facebook' => 'facebook.com/kbutsho', 'youtube' => 'youtube.com/kbutsho']
        ];
        Setting::insert($settings);
    }
}
