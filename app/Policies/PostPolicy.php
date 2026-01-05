<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine if the user can view any posts.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the post.
     */
    public function view(User $user, Post $post): bool
    {
        // Published posts can be viewed by anyone
        if ($post->is_published) {
            return true;
        }

        // Unpublished posts can only be viewed by the author, editors, or admins
        return $user->id === $post->author_id || $user->isEditor() || $user->isAdmin();
    }

    /**
     * Determine if the user can create posts.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create posts
    }

    /**
     * Determine if the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        // Admins and editors can edit any post
        if ($user->isAdmin() || $user->isEditor()) {
            return true;
        }

        // Authors can edit their own posts
        return $user->id === $post->author_id;
    }

    /**
     * Determine if the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        // Admins can delete any post
        if ($user->isAdmin()) {
            return true;
        }

        // Editors can delete any post
        if ($user->isEditor()) {
            return true;
        }

        // Authors can delete their own posts
        return $user->id === $post->author_id;
    }

    /**
     * Determine if the user can restore the post.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the post.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->isAdmin();
    }
}
