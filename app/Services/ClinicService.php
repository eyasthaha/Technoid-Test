<?php

namespace App\Services;

use App\Models\Clinic;

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

}