<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\User;

class ChatTestSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@lightbp.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('secret'),
        ]);

        // Create a conversation for every user (except admin)
        foreach (User::where('id', '!=', $admin->id)->get() as $participant) {
            $conversation = Conversation::firstOrCreate([
                'admin_id' => $admin->id,
                'participant_id' => $participant->id,
                'participant_type' => 'App\\Models\\User'
            ]);
            $conversation->messages()->create([
                'sender_id' => $admin->id,
                'sender_type' => 'App\\Models\\User',
                'message' => 'Hello, this is a seeded test message!'
            ]);
        }
    }
}
