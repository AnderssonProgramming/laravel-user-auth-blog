<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Run UserSeeder first.');
            return;
        }

        // Create published posts
        Post::factory()->count(20)->published()->create([
            'author_id' => $users->random()->id,
        ]);

        // Create draft posts
        Post::factory()->count(10)->draft()->create([
            'author_id' => $users->random()->id,
        ]);
    }
}
