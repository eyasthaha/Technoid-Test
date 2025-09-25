<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'contact_email' => $this->contact_email,
            'clinic_count' => $this->clinics_count ?? 0,
            'doctor_count' => $this->doctors_count ?? 0,
        ];

        // Include nested clinics & doctors only if loaded
        if ($this->relationLoaded('clinic')) {
            $data['clinic'] = $this->clinic->map(function ($clinic) {
                return [
                    'id' => $clinic->id,
                    'name' => $clinic->name,
                    'city' => $clinic->city,
                    'type' => $clinic->type,
                    'doctors' => $clinic->relationLoaded('doctors') 
                                    ? $clinic->doctors->map(fn($d) => [
                                        'id' => $d->id,
                                        'name' => $d->name,
                                        'specialty' => $d->speciality,
                                        'status' => $d->status,
                                    ])
                                    : [],
                ];
            });
        }

        return $data;
    }
}
