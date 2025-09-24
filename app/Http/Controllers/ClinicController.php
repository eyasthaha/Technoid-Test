<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClinicResource;
use App\Services\ClinicService;
use Illuminate\Http\Request;

class ClinicController extends Controller
{

    protected $clinicService;

    public function __construct(ClinicService $clinicService ) {
        $this->clinicService = $clinicService;
    }
    
    public function list(Request $request)
    {
        $clinics = $this->clinicService->filter($request->toArray());

        return ClinicResource::collection($clinics);
    }

}
