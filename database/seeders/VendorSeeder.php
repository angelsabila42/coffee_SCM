<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultVendors =[['name'=>'Ankole Coffee Processors Cooperative Society', 'region'=> 'Ankole', 'organicCertified'=> true],
                            ['name'=> 'Ankole Coffee Producers Coop Union', 'region'=> 'Ankole', 'organicCertified'=> true] , 
                            ['name'=> 'Banyankole Kweterana Cooperative Union', 'region'=> 'Ankole', 'organicCertified'=> true], 
                            ['name'=>"Kibinge Coffee Farmer's Cooperative Society", 'region'=> 'Central', 'organicCertified'=> false],
                            ['name'=>'Bukonzo Joint Cooperative Union', 'region'=> 'Western', 'organicCertified'=> true],
                            ['name'=>'Bugisu Cooperative Union', 'region'=> 'Eastern', 'organicCertified'=> true],
                            ['name'=>'National Union of Coffee Agribusinesses and Farm Enterprises (NUCAFE) Ltd', 'region'=> 'Central', 'organicCertified'=> false], 
                            ['name'=>'United Organic','region'=> 'Central', 'organicCertified'=> true],
                            ['name'=> 'Nsangi Coffee Farmers Association',  'region'=> 'Central', 'organicCertified'=> false],
                            ['name'=> 'Nile Highlands Arabica Coffee Farmers Association','region'=> 'Eastern', 'organicCertified'=> true],
                            ['name'=> 'Bukonzo Organic', 'region'=> 'Western', 'organicCertified'=> true]
                            ];
        
        foreach ($defaultVendors as $vendor){

            $existingVendor = Vendor::where('name', $vendor['name'])->first();
            if($existingVendor){
                $existingVendor->update([
                    'region' => $vendor['region'],
                    'organicCertified'=> $vendor['organicCertified'],
                ]);
                
            }else{
                Vendor::factory()->create([
                'name'=>$vendor['name'],
                'region'=> $vendor['region'],
                'organicCertified'=> $vendor['organicCertified'],
            ]);
            }
        }
    }
}
