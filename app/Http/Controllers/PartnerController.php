<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    
    public function list()
    {
        $user = Auth::user();
        
        // if ($user->role === 'partner_admin') {
        //     return response()->json(['message' => 'Forbidden'], 403);
        // }

        $partners = Partner::where('id', $user->model_id)->withCount('doctors','clinic')->paginate(50);

        return PartnerResource::collection($partners);
    }

    public function get($id){

        $user = Auth::user();

        $partner = Partner::with('clinic.doctors')->find($id);

        if(!$partner){
            return response()->json(['message' => 'Partner not found'], 404);
        }

        if ($user->role === 'partner_admin' && $user->model_id !== $partner->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        
        return PartnerResource::make($partner);

    }

}
