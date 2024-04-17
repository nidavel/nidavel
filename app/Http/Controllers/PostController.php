<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Events\PostPublished;
use App\Events\PagePublished;
use App\Events\PostDeleted;
use App\Events\PageDeleted;
use App\Events\PageRestored;

class PostController extends Controller
{
    /**
     * Display a listing of the resource to everyone.
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all()
        ]);
    }

    /**
     * Display a listing of the resource in the dashboard.
     */
    public function all(Request $request)
    {
        $filter = $request->filter;
        $limit = 5;
        if (!isset($filter) || $filter === '') {
            $posts = Post::where('post_type', 'post')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=posts/all');
            $subtitle = 'All Posts';
        }

        else if ($filter === 'published') {
            $posts = Post::where('post_type', 'post')
                ->where('status', 'published')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=posts/all/published');
            $subtitle = 'Published Posts';
        }

        else if ($filter === 'drafts') {
            $posts = Post::where('post_type', 'post')
                ->where('status', 'draft')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=posts/all/drafts');
            $subtitle = 'Drafts';
        }

        else if ($filter === 'trashed') {
            $posts = Post::where('post_type', 'post')
                ->onlyTrashed()
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=posts/all/trashed');
            $subtitle = 'Trashed Posts';
        }
        
        else {
            $posts = Post::where('post_type', 'post')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=posts/all');
            $subtitle = 'All Posts';
        }

        return view('dashboard.posts.index', [
            'posts'     => $posts,
            'subtitle'  => $subtitle
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->saveDraft($request);

        if (!empty($request->publish)) {
            $post->status = 'published';
            $post->save();

            switch ($post->post_type) {
                case 'post':
                    PostPublished::dispatch($post);
                    break;
                case 'page':
                    PagePublished::dispatch($post);
                    break;
                default:
                    PostPublished::dispatch($post);
            }
        }

        return redirect("/dashboard?route=posts/edit/$post->id");
    }

    /**
     * Saves draft a newly created post in storage.
     */
    public function saveDraft(StorePostRequest $request)
    {
        $featured_image = null;

        if (!empty($request->featured_image)) {
            $featured_image = ImageController::upload($request, 'featured_image');
        }
        
        return Post::create([
            'title'             => $request->title,
            'content'           => $request->content,
            'featured_image'    => $featured_image,
            'user_id'           => Auth::id(),
            'link'              => titleToLink($request->title),
            'post_type'         => $request->post_type,
            'description'       => $request->description,
            'keywords'          => $request->keywords,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = url()->current();
        $query = explode('/', $query);
        $queryString = $query[count($query) - 1];

        if ($queryString != (int) $queryString) {
            $post = Post::where('link', $queryString)->first();
        } else {
            $post = Post::find((int) $queryString);
        }

        $post->author = User::find($post->user_id)->name;

        return view('front.post', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $featured_image = $post->featured_image;

        if (!empty($request->featured_image)) {
            $featured_image = ImageController::upload($request, 'featured_image');
        }
        
        $post->update([
            'title'             => $request->title,
            'content'           => $request->content,
            'featured_image'    => $featured_image,
            'link'              => titleToLink($request->title),
            'post_type'         => $request->post_type,
            'description'       => $request->description,
            'keywords'          => $request->keywords,
        ]);

        if (!empty($request->updatePublish)) {
            $post->status = 'published';
            $post->save();

            switch ($post->post_type) {
                case 'post':
                    PostPublished::dispatch($post);
                    break;
                case 'page':
                    PagePublished::dispatch($post);
                    break;
                default:
                    PostPublished::dispatch($post);
                    break;
            }
        }

        return redirect()->back();
    }

    /**
     * Versatile update using update method
     */
    public function updateOnly(UpdatePostRequest $request, Post $post)
    {
        $this->update($request, $post);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePublish(UpdatePostRequest $request, Post $post)
    {
        $this->update($request, $post);

        if (!empty($request->updatePublish)) {
            $post->status = "published";
            $post->save();
        }

        switch ($post->post_type) {
            case 'post':
                PostPublished::dispatch($post);
                break;
            case 'page':
                PagePublished::dispatch($post);
                break;
            default:
                PostPublished::dispatch($post);
                break;
        }

        return redirect()->back();
    }

    /**
     * Marks the specified resource as deleted.
     */
    public function delete(Post $post)
    {
        $post->delete();

        switch ($post->post_type) {
            case 'post':
                PostDeleted::dispatch($post);
                break;
            case 'page':
                PageDeleted::dispatch($post);
                break;
            default:
                PostDeleted::dispatch($post);
                break;
        }

        return redirect()->back();
    }

    /**
     * Restores the specified deleted resource.
     */
    public function restore(Request $request)
    {
        $post = Post::onlyTrashed()->where('id', $request->post)->firstOrFail();
        $post->restore();

        if ($post->status === 'published') {
            switch ($post->post_type) {
                case 'post':
                    PostPublished::dispatch($post);
                    break;
                case 'page':
                    PagePublished::dispatch($post);
                    break;
                default:
                    PostPublished:dispatch($post);
                    break;
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Post::onlyTrashed()->where('id', $request->post)->forceDelete();
        return redirect()->back();
    }
}
