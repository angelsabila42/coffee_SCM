<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\conversation;
use App\Models\User;
use App\Models\Message;

class ChatTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder creates demo users (admin, vendor, supplier, transporter)
     * and ensures each user can chat with the others.
     */
    public function run(): void
    {
        // Create demo users
        $users = [
            [
                'name' => 'Alice Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Victor Vendor',
                'email' => 'vendor@example.com',
                'password' => bcrypt('password'),
                'role' => 'vendor',
            ],
            [
                'name' => 'Sam Supplier',
                'email' => 'supplier@example.com',
                'password' => bcrypt('password'),
                'role' => 'supplier',
            ],
            [
                'name' => 'Tina Transporter',
                'email' => 'transporter@example.com',
                'password' => bcrypt('password'),
                'role' => 'transporter',
            ],
        ];

        $userModels = [];
        foreach ($users as $userData) {
            $userModels[] = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Create a conversation between every pair of users (no duplicates)
        for ($i = 0; $i < count($userModels); $i++) {
            for ($j = $i + 1; $j < count($userModels); $j++) {
                $userA = $userModels[$i];
                $userB = $userModels[$j];

                $conversation = Conversation::firstOrCreate([
                    'user_one_id' => $userA->id,
                    'user_two_id' => $userB->id,
                ]);

                // Seed a welcome message from userA to userB if not present
                if (!$conversation->messages()->where('sender_id', $userA->id)->exists()) {
                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $userA->id,
                        'message' => 'Hello ' . $userB->name . ', this is a test message from ' . $userA->name . '!',
                    ]);
                }
            }
        }
    }
}
