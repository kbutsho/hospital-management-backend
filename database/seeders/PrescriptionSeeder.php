<?php

namespace Database\Seeders;

use App\Models\Prescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prescriptions = [
            ['appointment_id' => 1, 'doctor_id' => 1, 'patient_id' => 1, 'data' => '{"content":"<h2>Patient Name: John Doe</h2><h2>Date: January 28, 2024</h2><p><br></p><h3><strong>Medications:</strong></h3><p>1. Paracetamol</p><ul><li>&nbsp;&nbsp;Dosage: 500mg</li><li>&nbsp;&nbsp;Frequency: Every 6 hours</li><li>&nbsp;&nbsp;Duration: 7 days</li></ul><p><br></p><h3><strong>2. Amoxicillin</strong></h3><ul><li>&nbsp;&nbsp;Dosage: 250mg</li><li>&nbsp;&nbsp;Frequency: Twice daily</li><li>&nbsp;&nbsp;Duration: 10 days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
            ['appointment_id' => 2, 'doctor_id' => 1, 'patient_id' => 2, 'data' => '{"content":"<h2>Patient Name: John Doe</h2><h2>Date: January 28, 2024</h2><p><br></p><h3><strong>Medications:</strong></h3><p>1. Paracetamol</p><ul><li>&nbsp;&nbsp;Dosage: 500mg</li><li>&nbsp;&nbsp;Frequency: Every 6 hours</li><li>&nbsp;&nbsp;Duration: 7 days</li></ul><p><br></p><h3><strong>2. Amoxicillin</strong></h3><ul><li>&nbsp;&nbsp;Dosage: 250mg</li><li>&nbsp;&nbsp;Frequency: Twice daily</li><li>&nbsp;&nbsp;Duration: 10 days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
            ['appointment_id' => 3, 'doctor_id' => 1, 'patient_id' => 3, 'data' => '{"content":"<h2>Patient Name: John Doe</h2><h2>Date: January 28, 2024</h2><p><br></p><h3><strong>Medications:</strong></h3><p>1. Paracetamol</p><ul><li>&nbsp;&nbsp;Dosage: 500mg</li><li>&nbsp;&nbsp;Frequency: Every 6 hours</li><li>&nbsp;&nbsp;Duration: 7 days</li></ul><p><br></p><h3><strong>2. Amoxicillin</strong></h3><ul><li>&nbsp;&nbsp;Dosage: 250mg</li><li>&nbsp;&nbsp;Frequency: Twice daily</li><li>&nbsp;&nbsp;Duration: 10 days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
            ['appointment_id' => 14, 'doctor_id' => 4, 'patient_id' => 3, 'data' => '{"content":"<h2>Patient Name: John Doe</h2><h2>Date: January 28, 2024</h2><p><br></p><h3><strong>Medications:</strong></h3><p>1. Paracetamol</p><ul><li>&nbsp;&nbsp;Dosage: 500mg</li><li>&nbsp;&nbsp;Frequency: Every 6 hours</li><li>&nbsp;&nbsp;Duration: 7 days</li></ul><p><br></p><h3><strong>2. Amoxicillin</strong></h3><ul><li>&nbsp;&nbsp;Dosage: 250mg</li><li>&nbsp;&nbsp;Frequency: Twice daily</li><li>&nbsp;&nbsp;Duration: 10 days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
        ];
        Prescription::insert($prescriptions);
    }
}
