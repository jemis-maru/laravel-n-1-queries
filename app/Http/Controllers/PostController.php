<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // // ❌ N+1 Query Problem
        // $posts = Post::all(); // no eager load
        // foreach ($posts as $post) {
        //     $post->user->name; // triggers a query for each post
        // }

        // ✅ Fixed using eager loading
        $posts = Post::with('user')->get();

        foreach ($posts as $post) {
            $post->user->name; // No additional query now
        }

        return view('posts.index', compact('posts'));
    }
}
