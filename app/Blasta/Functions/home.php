<?php

use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\PinPostController;

function home()
{
    $settings       = Settings::getInstance();
    $homepage       = $settings->get('general', 'homepage');
    $limit          = $settings->get('general', 'query_limit');

    if ($homepage === 'default') {
        $pinController  = new PinPostController;
        $pinned         = $pinController->getPinnedIDs();
        $pinnedPosts    = collect([]);
        $unpinnedPosts = Post::where('post_type', 'post')
            ->where('status', 'published')
            ->whereNot(function($query) use ($pinned) {
                $query->whereIn('id', $pinned);
            })
            ->latest()
            ->orderBy('id', 'DESC')
            ->paginate($limit);
        $unpinnedPosts->withPath('/');

        foreach ($pinned as $pin) {
            $pinnedPost         = Post::where('id', $pin)->get();
            $pinnedPost->pinned = true;
            $pinnedPosts        = $pinnedPosts->concat($pinnedPost);
        }
        
        
        $posts = $pinnedPosts->concat($unpinnedPosts);

        return view('front.posts', [
            "posts" => $posts
        ]);
    }
    else if ($homepage == (int) $homepage) {
        $page           = Post::find($homepage);
        $page->author   = User::find($page->user_id)->name;
        return view('front.page', [
            'post' => $page
        ]);
    }
    else {
        return view('front.pages.' . $homepage);
    }
}
