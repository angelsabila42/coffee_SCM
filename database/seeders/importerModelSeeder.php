<?php

namespace Database\Seeders;

use App\Models\importerModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class importerModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //      for ($i = 0; $i < 11; $i++) {
    //     importerModel::factory()->create([
    //         'created_at' => Carbon::now()->subMonth()->addDays(rand(0, 20)),
    //     ]);
    // }
    //     for ($i = 0; $i < 9; $i++) {
    //     importerModel::factory()->create([
    //         'created_at' => Carbon::now()->subDays(rand(0, now()->day - 1)),
    //     ]);
    //     }
        //// importerModel::factory()->count(20)->create();

        $defaultImporters =[['name'=>'Sucafina', 'country' => 'Switzerland'],
                            ['name'=> 'Olam International', 'country'=> 'Singapore'] , 
                            ['name'=> 'Touton SA', 'country'=> 'France'], 
                            ['name'=>'Hafco Trading', 'country'=> 'Sudan'],
                            ['name'=>'Ecom Agro Industrialist', 'country'=> 'Switzerland'],
                            ['name'=>'Bernhard Rothfos', 'country'=> 'Germany'],
                            ['name'=>'Volcafe', 'country'=> 'Switzerland'], 
                            ['name'=>'Louis Dreyfus', 'country'=> 'Netherlands'],
                            ['name'=> 'Aldwami Co', 'country'=>'Sudan'],
                            ['name'=> 'Altasheel Import and Export', 'country'=> 'Sudan']
                            ];

        $mapping = [
                    'Switzerland' => 'Europe',
                    'France' => 'Europe',
                    'Germany' => 'Europe',
                    'Singapore' => 'Asia',
                    'Sudan' => 'Africa',
                    'Netherlands' => 'Europe',
                    // Add more as needed
                 ]; 

        foreach ($defaultImporters as $index => $importer){

            if($index < 3){
                $createdAt = Carbon::now()->subMonth()->addDays(rand(0, 20));
            }else{
                 Carbon::now()->subDays(rand(0, now()->day - 1));
            }
            $continent = $mapping[$importer['country']] ?? null;

            $existingImporter = importerModel::where('name', $importer['name'])->first();
            if($existingImporter){
                $existingImporter->update([
                    'country' => $importer['country'],
                    'continent' => $continent,
                    'created_at' => $createdAt,
                ]);
                
            }else{
                importerModel::factory()->create([
                'name'=>$importer['name'],
                'country'=> $importer['country'],
                'continent' => $continent,
                'created_at'=> $createdAt,
            ]);
            }
        }
    }
}
