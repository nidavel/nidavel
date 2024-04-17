<?php

use App\Models\Post;
use App\Models\User;

function home()
{
    $settings = Settings::getInstance();
    $homepage = $settings->get('general', 'homepage');
    $limit = $settings->get('general', 'query_limit');

    if ($homepage === 'default') {
        $posts = Post::where('post_type', 'post')
            ->where('status', 'published')
            ->latest()
            ->orderBy('id', 'DESC')
            // ->limit($limit)
            ->get();
        return view('front.posts', [
            "posts" => $posts
        ]);
    }
    else if ($homepage == (int) $homepage) {
        $page = Post::find($homepage);
        $page->author = User::find($page->user_id)->name;
        return view('front.page', [
            'post' => $page
        ]);
    }
    else {
        return view('front.pages.' . $homepage);
    }
}
