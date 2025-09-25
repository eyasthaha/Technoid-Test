<?php

namespace App\Services;

use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class DoctorService
{
    
    public function filter(array $request){

        $user = Auth::user();

        return Doctor::when(isset($request['status']), function ($query) use ($request) {
                            $query->where('status',$request['status']);
                        })->when(isset($request['speciality']), function ($query) use ($request) {
                            $query->where('speciality', $request['speciality']);
                        })
                    ->when($user->role === 'partner_admin', function ($query) use ($user) {
                        $query->whereHas('clinic', function ($q) use ($user) {
                            $q->where('partner_id', $user->model_id);
                        });
                    })
                    ->when($user->role === 'clinic_admin', function ($query) use ($user) {
                            $query->where('clinic_id', $user->model_id);
                    })
                    ->with('user')
                    ->paginate(50);

    }

}