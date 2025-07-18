<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transporter;

class CreateSampleTransporters extends Command
{
    protected $signature = 'create:sample-transporters';
    protected $description = 'Create sample transporter companies for testing';

    public function handle()
    {
        $this->info('Creating sample transporter companies...');

        // Sample transporter 1
        Transporter::create([
            'name' => 'John Mubarak',
            'co_name' => 'Swift Transport Uganda',
            'email' => 'john@swifttransport.ug',
            'password' => bcrypt('password'),
            'phone_number' => '+256701234567',
            'address' => 'Kampala, Uganda',
            'Bank_account' => '1234567890',
            'Account_holder' => 'Swift Transport Uganda Ltd',
            'Bank_name' => 'Stanbic Bank',
        ]);

        // Sample transporter 2
        Transporter::create([
            'name' => 'Sarah Nakamura',
            'co_name' => 'Express Cargo Limited',
            'email' => 'sarah@expresscargo.ug',
            'password' => bcrypt('password'),
            'phone_number' => '+256702345678',
            'address' => 'Entebbe, Uganda',
            'Bank_account' => '2345678901',
            'Account_holder' => 'Express Cargo Limited',
            'Bank_name' => 'Centenary Bank',
        ]);

        // Sample transporter 3
        Transporter::create([
            'name' => 'David Olema',
            'co_name' => 'Northern Logistics Co.',
            'email' => 'david@northernlogistics.ug',
            'password' => bcrypt('password'),
            'phone_number' => '+256703456789',
            'address' => 'Gulu, Uganda',
            'Bank_account' => '3456789012',
            'Account_holder' => 'Northern Logistics Company',
            'Bank_name' => 'DFCU Bank',
        ]);

        $this->info('✅ Successfully created 3 sample transporter companies:');
        $this->line('  1. Swift Transport Uganda');
        $this->line('  2. Express Cargo Limited');
        $this->line('  3. Northern Logistics Co.');
        
        $this->info('📊 Total transporters in database: ' . Transporter::count());
    }
}
