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
        Partner::factory()->count(5000)->create();

        // Fetch inserted IDs
        $partnerIds = DB::table('partners')
            ->latest('id','name') // fetch newest 5000 partners
            ->limit(5000)
            ->get(['id','name','contact_email'])
            ->toArray();

        $password = Hash::make('password');

        $partnerChunks = array_chunk($partnerIds, 500);

        foreach ($partnerChunks as $chunk) {
            $entitiesData = [];

            foreach ($chunk as $partner) {
                // If $partner is object, use $partner->id and $partner->name
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

            // Bulk insert this chunk
            DB::table('users')->insert($entitiesData);
        }
    }
}
