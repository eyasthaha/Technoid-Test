<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClinicService
{
    
    public function filter(array $request){

        return Clinic::when(isset($request['city']), function ($query) use ($request) {
                            $query->where('city','LIKE', "%{$request['city']}%");
                        })->when(isset($request['partner_id']), function ($query) use ($request) {
                            $query->where('partner_id', $request['partner_id']);
                        })
                    ->paginate(50);

    }

    public function createDoctor(array $data){

        $user = Auth::user();
        
         $doctor = Doctor::create([
                    'name' => $data['name'],
                    'speciality' => $data['speciality'],
                    'clinic_id' => $data['clinic_id'],
                    'status' => 'active',
                ]);

        $doctor->user()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        return $doctor->load('user');

    }

    public function updateDoctorStatus($id, array $data){

        $doctor = Doctor::findOrFail($id);
        $doctor->update([
            'status' => $data['status'],
        ]);

        return $doctor->load('user');

    }

}