<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creating 5000 partners.
        Partner::factory()->count(5000)->create();

        // Fetch the latest 5000 partner IDs with names and contact emails
        $partnerIds = DB::table('partners')
            ->latest('id','name')
            ->limit(5000)
            ->get(['id','name','contact_email'])
            ->toArray();

        
        $password = Hash::make('password');

        $entitiesData = [];

        // Create Partner Admin Entities
        foreach ($partnerIds as $partner) {

            $now = now();
            $entitiesData[] = [
                'name' => "{$partner->name} {$partner->id} Admin",
                'email' => $partner->contact_email,
                'password' => $password,
                'role' => 'partner_admin',
                'model_type' => 'Partner',
                'model_id' => $partner->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];

        }

        // Insert in batches of 1000.
        foreach (array_chunk($entitiesData, 1000) as $chunk) {
            DB::table('users')->insert($chunk);            
        }
    }
}
