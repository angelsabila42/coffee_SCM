<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Transporter;
use Illuminate\Support\Facades\DB;

class CreateSampleDrivers extends Command
{
    protected $signature = 'create:sample-drivers';
    protected $description = 'Create sample drivers with transporter associations';

    public function handle()
    {
        $this->info('Creating sample drivers...');

        // First ensure we have transporters
        if (Transporter::count() == 0) {
            $this->info('Creating sample transporters first...');
            $this->call('create:sample-transporters');
        }

        $transporters = Transporter::all();
        if ($transporters->count() < 3) {
            $this->error('Need at least 3 transporters. Please run create:sample-transporters first.');
            return;
        }

        // Get transporter IDs
        $swift = $transporters->where('co_name', 'Swift Transport Uganda')->first();
        $express = $transporters->where('co_name', 'Express Cargo Limited')->first();
        $northern = $transporters->where('co_name', 'Northern Logistics Co.')->first();

        $drivers = [
            // Swift Transport Uganda drivers
            [
                'name' => 'James Okello',
                'email' => 'james.okello@driver.com',
                'phone' => '+256704111001',
                'address' => 'Nakawa, Kampala',
                'license_number' => 'DL001234',
                'vehicle_number' => 'UAK-101A',
                'experience' => '5',
                'transporter_company' => $swift->co_name,
                'transporter_company_id' => $swift->id,
            ],
            [
                'name' => 'Grace Namuli',
                'email' => 'grace.namuli@driver.com',
                'phone' => '+256704111002',
                'address' => 'Bugolobi, Kampala',
                'license_number' => 'DL001235',
                'vehicle_number' => 'UAK-102B',
                'experience' => '3',
                'transporter_company' => $swift->co_name,
                'transporter_company_id' => $swift->id,
            ],
            // Express Cargo Limited drivers
            [
                'name' => 'Peter Mugisha',
                'email' => 'peter.mugisha@driver.com',
                'phone' => '+256704222001',
                'address' => 'Wakiso, Entebbe Road',
                'license_number' => 'DL002001',
                'vehicle_number' => 'UAW-201C',
                'experience' => '7',
                'transporter_company' => $express->co_name,
                'transporter_company_id' => $express->id,
            ],
            [
                'name' => 'Mary Achieng',
                'email' => 'mary.achieng@driver.com',
                'phone' => '+256704222002',
                'address' => 'Entebbe Town',
                'license_number' => 'DL002002',
                'vehicle_number' => 'UAW-202D',
                'experience' => '4',
                'transporter_company' => $express->co_name,
                'transporter_company_id' => $express->id,
            ],
            // Northern Logistics drivers
            [
                'name' => 'Samuel Atiku',
                'email' => 'samuel.atiku@driver.com',
                'phone' => '+256704333001',
                'address' => 'Gulu Town',
                'license_number' => 'DL003001',
                'vehicle_number' => 'UAG-301E',
                'experience' => '8',
                'transporter_company' => $northern->co_name,
                'transporter_company_id' => $northern->id,
            ],
            [
                'name' => 'Florence Akello',
                'email' => 'florence.akello@driver.com',
                'phone' => '+256704333002',
                'address' => 'Kitgum Road, Gulu',
                'license_number' => 'DL003002',
                'vehicle_number' => 'UAG-302F',
                'experience' => '6',
                'transporter_company' => $northern->co_name,
                'transporter_company_id' => $northern->id,
            ],
        ];

        foreach ($drivers as $driverData) {
            // Check if driver already exists
            if (User::where('email', $driverData['email'])->exists()) {
                $this->line("Driver {$driverData['name']} already exists, skipping...");
                continue;
            }

            User::create([
                'name' => $driverData['name'],
                'email' => $driverData['email'],
                'password' => bcrypt('password'),
                'role' => 'driver',
                'phone' => $driverData['phone'],
                'address' => $driverData['address'],
                'license_number' => $driverData['license_number'],
                'vehicle_number' => $driverData['vehicle_number'],
                'experience' => $driverData['experience'],
                'is_available' => true,
                'transporter_company' => $driverData['transporter_company'],
                'transporter_company_id' => $driverData['transporter_company_id'],
                'email_verified_at' => now(),
            ]);

            $this->line("✅ Created driver: {$driverData['name']} for {$driverData['transporter_company']}");
        }

        $this->info('📊 Driver summary by company:');
        foreach ($transporters as $transporter) {
            $driverCount = User::where('transporter_company_id', $transporter->id)
                              ->where('role', 'driver')
                              ->count();
            $this->line("  {$transporter->co_name}: {$driverCount} drivers");
        }

        $this->info('🎉 Sample drivers created successfully!');
    }
}
