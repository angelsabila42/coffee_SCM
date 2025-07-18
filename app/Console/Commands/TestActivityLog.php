<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ImporterRecentActivities;
use App\Models\User;
use App\Models\ImporterModel;

class TestActivityLog extends Command
{
    protected $signature = 'test:activity-log';
    protected $description = 'Test activity log functionality with sample login/logout data';

    public function handle()
    {
        // Find any user (we'll create logs for the first user)
        $user = User::first();
        if (!$user) {
            $this->error('No users found in the database');
            return;
        }

        $this->info('Creating test activity logs for user ID: ' . $user->id . ' (Email: ' . $user->email . ')');

        // Create a login activity
        ImporterRecentActivities::create([
            'user_id' => $user->id,
            'type' => 'login',
            'title' => 'User logged in successfully',
            'data' => [
                'login_time' => now()->subHours(2)->format('Y-m-d H:i:s'),
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ],
            'ip_address' => '192.168.1.100'
        ]);

        // Create a logout activity
        ImporterRecentActivities::create([
            'user_id' => $user->id,
            'type' => 'logout',
            'title' => 'User logged out successfully',
            'data' => [
                'logout_time' => now()->subMinutes(30)->format('Y-m-d H:i:s'),
                'ip_address' => '192.168.1.100',
                'session_duration' => '1 hour 30 minutes'
            ],
            'ip_address' => '192.168.1.100'
        ]);

        // Create another login activity (more recent)
        ImporterRecentActivities::create([
            'user_id' => $user->id,
            'type' => 'login',
            'title' => 'User logged in successfully',
            'data' => [
                'login_time' => now()->subMinutes(15)->format('Y-m-d H:i:s'),
                'ip_address' => '192.168.1.101',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X)'
            ],
            'ip_address' => '192.168.1.101'
        ]);

        // Create a security activity for testing
        ImporterRecentActivities::create([
            'user_id' => $user->id,
            'type' => 'security',
            'title' => 'Password changed successfully',
            'data' => [
                'change_time' => now()->subDays(1)->format('Y-m-d H:i:s'),
                'ip_address' => '192.168.1.100'
            ],
            'ip_address' => '192.168.1.100'
        ]);

        $this->info('Test activity logs created successfully!');
        $this->info('Created activities: login, logout, login, security');
        $this->info('You can now view them in the importer dashboard.');
    }
}
