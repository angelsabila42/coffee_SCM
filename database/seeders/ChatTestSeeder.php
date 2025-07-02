<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\User;

class ChatTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder ensures the admin user exists and creates a seeded conversation with every other user.
     * It also ensures no duplicate messages are created if run multiple times.
     */
    public function run(): void
    {
        // Get or create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@lightbp.com'
        ],
         [
            'name' => 'Admin',
            'password' => bcrypt('secret'),
        ]);

        // Create some test users if none exist (besides admin)
        if (User::where('id', '!=', $admin->id)->count() === 0) {
            $testUsers = [
                ['name' => 'Vendor One', 'email' => 'vendor1@example.com'],
                ['name' => 'Vendor Two', 'email' => 'vendor2@example.com'],
                ['name' => 'Partner Three', 'email' => 'partner3@example.com'],
            ];
            foreach ($testUsers as $userData) {
                User::firstOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => bcrypt('secret'),
                    ]
                );
            }
        }

        // Refresh the list of users (excluding admin)
        foreach (User::where('id', '!=', $admin->id)->get() as $participant) {
            $conversation = \App\Models\Conversation::firstOrCreate([
                'admin_id' => $admin->id,
                'participant_id' => $participant->id,
                'participant_type' => 'App\\Models\\User'
            ]);
            // Only seed the message if not already present
            if (!$conversation->messages()->where('sender_id', $admin->id)->exists()) {
                $conversation->messages()->create([
                    'sender_id' => $admin->id,
                    'sender_type' => 'App\\Models\\User',
                    'message' => 'Hello, this is a seeded test message!'
                ]);
            }
        }
    }
}
