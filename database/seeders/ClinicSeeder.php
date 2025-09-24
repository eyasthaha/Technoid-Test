<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $partners = Partner::all();

        $clinicData = [];

        foreach ($partners as $partner) {
            // Each partner gets 3 clinics.
            for ($i = 0; $i < 3; $i++) {
                $clinicData[] = [
                    'partner_id' => $partner->id,
                    'name'       => $faker->company . $faker->randomElement(['Hospital', 'Lab', 'Clinic']),
                    'city'       => $faker->city,
                    'type'       => $faker->randomElement(['hospital', 'lab', 'clinic']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($clinicData, 1000) as $chunk) {
            DB::table('clinics')->insert($chunk);
        }

        // Fetch all clinic IDs
        $clinicIds = DB::table('clinics')->pluck('id', 'name');

        $password = Hash::make('password');

        // Create Clinic Admin Entities
        $clinicEntities = [];
        foreach ($clinicIds as $clinicName => $clinicId) {
            $now = now();
            $clinicEntities[] = [
                'name'       => "$clinicName Admin",
                'email'      => $faker->unique()->safeEmail,
                'password'   => $password,
                'role'       => 'clinic_admin',
                'model_type' => 'Clinic',
                'model_id'   => $clinicId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($clinicEntities, 1000) as $chunk) {
            DB::table('users')->insert($chunk);
        }
    }
}
