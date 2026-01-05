<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Get posts based on user role
        $query = Post::with('author')->latest('created_at');

        if ($user->isAdmin() || $user->isEditor()) {
            // Admins and editors see all posts
            $posts = $query->paginate(15);
        } else {
            // Regular users only see their own posts
            $posts = $query->where('author_id', $user->id)->paginate(15);
        }

        $stats = [
            'total_posts' => $posts->total(),
            'published' => Post::when(!$user->isAdmin() && !$user->isEditor(), function ($q) use ($user) {
                $q->where('author_id', $user->id);
            })->where('is_published', true)->count(),
            'drafts' => Post::when(!$user->isAdmin() && !$user->isEditor(), function ($q) use ($user) {
                $q->where('author_id', $user->id);
            })->where('is_published', false)->count(),
        ];

        return view('dashboard', compact('posts', 'stats'));
    }
}
