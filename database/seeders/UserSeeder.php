<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Entity;
use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $password = Hash::make('password');
        
        $partner = Partner::create([
                        'name' => 'Technoid Demo Partner',
                        'contact_email' => 'partner@demo.com',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

        Entity::create([
            'name'       => $partner->name,
            'email'      => $partner->contact_email,
            'password'   => $password,
            'role'       => 'partner_admin',
            'model_type' => Partner::class,
            'model_id'   => $partner->id 
        ]);


        $clinic = Clinic::create([
                    'partner_id' => $partner->id,
                    'name' => 'Technoid Demo Clinic',
                    'city' => 'Demo City',
                    'type' => 'clinic'
                ]);

        Entity::create([
            'name'       => $clinic->name,
            'email'      => 'clinic@demo.com',
            'password'   => $password,
            'role'       => 'clinic_admin',
            'model_type' => Clinic::class,
            'model_id'   => $clinic->id 
        ]);

        // 2 more clinics using factory
        $moreClinics = Clinic::factory()->count(2)->create([
            'partner_id' => $partner->id,
        ]);

        foreach ($moreClinics as $c) {
            Entity::create([
                'name'       => $c->name,
                'email'      => $c->contact_email ?? fake()->safeEmail(),
                'password'   => $password,
                'role'       => 'clinic',
                'model_type' => Clinic::class,
                'model_id'   => $c->id,
            ]);
        }

        $clinicIds = Clinic::all()->pluck('id');

        foreach($clinicIds as $clinicId) {

            for($i = 0; $i < 5; $i++) {

                $doctor = Doctor::create([
                        'clinic_id' => $clinicId,
                        'name' => fake()->name(),
                        'speciality' => fake()->randomElement(['Cardiology', 'Dermatology', 'Neurology', 'Pediatrics', 'Psychiatry']),
                        'status' => 'active'
                    ]);

                Entity::create([
                    'name'       => $doctor->name,
                    'email'      => $doctor->name.'@gmail.com',
                    'password'   => $password,
                    'role'       => 'doctor',
                    'model_type' => Doctor::class,
                    'model_id'   => $doctor->id 
                ]);

            }
        }



    }
}
