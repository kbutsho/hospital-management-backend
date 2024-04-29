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
            ['appointment_id' => 1, 'doctor_id' => 1, 'patient_id' => 1, 'history' => '{"dxHistoryContent":"<h3>Dx:</h3><ul><li>Acute Bronchitis</li><li>Hypertension</li><li>Diabetes Mellitus Type 2</li></ul><h3>Test:</h3><ul><li>Complete Blood Count (CBC)</li><li>Electrocardiogram (ECG)</li><li>Magnetic Resonance Imaging (MRI)</li><li>Computed Tomography (CT) Scan</li><li>X-ray</li><li>Urinalysis</li><li>Blood Glucose Test</li><li>Lipid Panel Test</li><li>Thyroid Function Test</li><li>Liver Function Test</li></ul>"}', 'medication' => '{"medicationContent":"<h3><strong>Rx:</strong></h3><ul><li>Ibuprofen (200mg) 1 + 1 + 1 (empty stomach) – 30 Days</li><li>Paracetamol (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Amoxicillin (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Omeprazole (20mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Metformin (500mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Aspirin 75mg 1 + 0 + 1 (after meals) – 30 Days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
            ['appointment_id' => 2, 'doctor_id' => 1, 'patient_id' => 2, 'history' => '{"dxHistoryContent":"<h3>Dx:</h3><ul><li>Acute Bronchitis</li><li>Hypertension</li><li>Diabetes Mellitus Type 2</li></ul><h3>Test:</h3><ul><li>Complete Blood Count (CBC)</li><li>Electrocardiogram (ECG)</li><li>Magnetic Resonance Imaging (MRI)</li><li>Computed Tomography (CT) Scan</li><li>X-ray</li><li>Urinalysis</li><li>Blood Glucose Test</li><li>Lipid Panel Test</li><li>Thyroid Function Test</li><li>Liver Function Test</li></ul>"}', 'medication' => '{"medicationContent":"<h3><strong>Rx:</strong></h3><ul><li>Ibuprofen (200mg) 1 + 1 + 1 (empty stomach) – 30 Days</li><li>Paracetamol (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Amoxicillin (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Omeprazole (20mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Metformin (500mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Aspirin 75mg 1 + 0 + 1 (after meals) – 30 Days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
            // ['appointment_id' => 3, 'doctor_id' => 1, 'patient_id' => 3, 'history' => '{"dxHistoryContent":"<h3>Dx:</h3><ul><li>Acute Bronchitis</li><li>Hypertension</li><li>Diabetes Mellitus Type 2</li></ul><h3>Test:</h3><ul><li>Complete Blood Count (CBC)</li><li>Electrocardiogram (ECG)</li><li>Magnetic Resonance Imaging (MRI)</li><li>Computed Tomography (CT) Scan</li><li>X-ray</li><li>Urinalysis</li><li>Blood Glucose Test</li><li>Lipid Panel Test</li><li>Thyroid Function Test</li><li>Liver Function Test</li></ul>"}', 'medication' => '{"medicationContent":"<h3><strong>Rx:</strong></h3><ul><li>Ibuprofen (200mg) 1 + 1 + 1 (empty stomach) – 30 Days</li><li>Paracetamol (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Amoxicillin (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Omeprazole (20mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Metformin (500mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Aspirin 75mg 1 + 0 + 1 (after meals) – 30 Days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
            // ['appointment_id' => 14, 'doctor_id' => 4, 'patient_id' => 3, 'history' => '{"dxHistoryContent":"<h3>Dx:</h3><ul><li>Acute Bronchitis</li><li>Hypertension</li><li>Diabetes Mellitus Type 2</li></ul><h3>Test:</h3><ul><li>Complete Blood Count (CBC)</li><li>Electrocardiogram (ECG)</li><li>Magnetic Resonance Imaging (MRI)</li><li>Computed Tomography (CT) Scan</li><li>X-ray</li><li>Urinalysis</li><li>Blood Glucose Test</li><li>Lipid Panel Test</li><li>Thyroid Function Test</li><li>Liver Function Test</li></ul>"}', 'medication' => '{"medicationContent":"<h3><strong>Rx:</strong></h3><ul><li>Ibuprofen (200mg) 1 + 1 + 1 (empty stomach) – 30 Days</li><li>Paracetamol (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Amoxicillin (500mg) 1 + 1 + 1 (after meals) – 30 Days</li><li>Omeprazole (20mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Metformin (500mg) 1 + 0 + 1 (after meals) – 30 Days</li><li>Aspirin 75mg 1 + 0 + 1 (after meals) – 30 Days</li></ul>"}', 'created_at' => now(), 'updated_at' => now()],
        ];
        Prescription::insert($prescriptions);
    }
}
