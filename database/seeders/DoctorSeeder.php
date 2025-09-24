<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $clinicIds = Clinic::pluck('id')->toArray();
        $doctors = [];
        $faker = \Faker\Factory::create();
        $specialities = ['Cardiology', 'Dermatology', 'Neurology', 'Pediatrics', 'Psychiatry', 'Oncology', 'Radiology', 'Surgery'];
        $statuses = ['active', 'inactive'];
        $now = now();

        foreach ($clinicIds as $clinicId) {

            for ($i = 0; $i < 5; $i++) {
                $doctors[] = [
                    'clinic_id' => $clinicId,
                    'name' => $faker->name,
                    'speciality' => $faker->randomElement($specialities),
                    'status' => $faker->randomElement($statuses),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

        }

        foreach (array_chunk($doctors, 1000) as $chunk) {
            DB::table('doctors')->insert($chunk);
        }

    }
}
