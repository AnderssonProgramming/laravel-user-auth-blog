<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles
        Role::create(['name' => 'admin', 'description' => 'Administrator']);
        Role::create(['name' => 'editor', 'description' => 'Editor']);
        Role::create(['name' => 'user', 'description' => 'User']);
    }

    public function test_user_can_view_published_posts(): void
    {
        $post = Post::factory()->published()->create();

        $response = $this->get(route('posts.show', $post));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_user_cannot_view_draft_posts(): void
    {
        $post = Post::factory()->draft()->create();

        $response = $this->get(route('posts.show', $post));

        $response->assertStatus(404);
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Test Post',
            'content' => 'This is test content for the post.',
            'is_published' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'author_id' => $user->id,
        ]);
    }

    public function test_user_can_edit_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $user->id]);

        $response = $this->actingAs($user)->patch(route('posts.update', $post), [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'is_published' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_user_cannot_edit_others_post(): void
    {
        $author = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $author->id]);

        $response = $this->actingAs($otherUser)->patch(route('posts.update', $post), [
            'title' => 'Hacked Title',
            'content' => 'Hacked content',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_edit_any_post(): void
    {
        $admin = User::factory()->admin()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($admin)->patch(route('posts.update', $post), [
            'title' => 'Admin Updated',
            'content' => 'Content updated by admin',
            'is_published' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Admin Updated',
        ]);
    }

    public function test_user_can_delete_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post));

        $response->assertRedirect();
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
}
