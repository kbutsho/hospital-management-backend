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
            [
                'organization_name' => 'Elite Care Hospital',
                'address' => 'Greams Lane, 21, Greams Rd, Thousand Lights, Chennai, Tamil Nadu 600006, India',
                'about' => "Welcome to our hospital management website, your comprehensive gateway to accessing vital information about our healthcare services. Our website is designed to provide patients and visitors with easy access to essential details, including department information and profiles of experienced doctors. Explore our various departments, each dedicated to specialized areas of medical care such as internal medicine, surgery, obstetrics and gynecology, pediatrics, emergency medicine, and radiology. Within each department, you'll find a team of skilled professionals committed to delivering compassionate and effective treatment. Our website also features profiles of our experienced doctors, showcasing their expertise and dedication to providing top-quality care to our patients. Whether you're seeking information about our services, looking to schedule an appointment, or simply want to learn more about our hospital, our website is here to guide you every step of the way.",
                'phone' => '+8801749555864',
                'email' => 'kbutsho@gmail.com',
                'facebook' => 'facebook.com/kbutsho',
                'youtube' => 'youtube.com/kbutsho',
                'footer_text' => "Welcome to our website. Our website is designed to provide patients and visitors with easy access to essential details"
            ]
        ];
        Setting::insert($settings);
    }
}
