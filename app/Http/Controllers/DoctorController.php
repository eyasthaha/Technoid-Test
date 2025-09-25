<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    protected $doctorService;

    public function __construct(DoctorService $doctorService ) {
        $this->doctorService = $doctorService;
    }
    
    public function list(Request $request)
    {
        // You can implement filtering logic here if needed
        $doctors = $this->doctorService->filter($request->toArray());
        
        return DoctorResource::collection($doctors);
    }
    
}
