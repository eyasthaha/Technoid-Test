<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\DoctorResource;
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

    public function create(DoctorRequest $request)
    {

        $clinic = $this->clinicService->createDoctor($request->validated());

        return DoctorResource::make($clinic);
    }

    public function updateDoctorStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $data = $this->clinicService->updateDoctorStatus($id, $validated);

        return DoctorResource::make($data);
    }

}
