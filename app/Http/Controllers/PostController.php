<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\PinPost;
use App\Http\Controllers\PinPostController;
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
        $limit = settings('r', 'general.query_limit');
        $pinController = new PinPostController;
        
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

        else if ($filter === 'search') {
            $q = $request->q;
            $posts = Post::where('title', 'LIKE', "%$q%")
                ->orWhere('content', 'LIKE', "%$q%")
                ->orWhere('keywords', 'LIKE', "%$q%")
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath("/dashboard?route=posts/all/search&q=$q");
            $subtitle = "Search results for '$q'";
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
            'subtitle'  => $subtitle,
            'pinned'    => $pinController->getPinnedIDs()
        ]);
    }

    /**
     * Display a listing of the search resource in the dashboard.
     */
    public function search(Request $request)
    {
        $q = $request->q;
        return redirect()
            ->to("http://localhost:8000/dashboard?route=posts/all/search&q=$q");
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
                    runFunctionsOnPostEvent('post-publish', $post);
                    break;
                case 'page':
                    PagePublished::dispatch($post);
                    runFunctionsOnPostEvent('post-publish', $post);
                    break;
                default:
                    PostPublished::dispatch($post);
                    runFunctionsOnPostEvent('post-publish', $post);
            }
            addDashboardNotice('post_publish', [
                'title' => 'Post published',
                'message' => "Post '$post->title' has been published.",
                'type' => 'success'
            ]);
        } else {
            addDashboardNotice('post_save', [
                'title' => 'Post save draft',
                'message' => "Post '$post->title' has been saved.",
                'type' => 'info'
            ]);
        }

        return redirect("/dashboard?route=posts/edit/$post->id");
    }

    /**
     * Saves draft a newly created post in storage.
     */
    public function saveDraft(StorePostRequest $request)
    {
        $featured_image = null;
        $category_id    = null;

        if (!empty($request->featured_image)) {
            $featured_image = ImageController::upload($request, 'featured_image');
        }
        if (!empty($request->category)) {
            $category_id = Category::where('name', $request->category)->first();
            if (!is_null($category_id)) {
                $category_id = $category_id->id;
            } else {
                $category_id = Category::create(['name' => $request->category]);
            }
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
            'category_id'       => $category_id,
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
        $post->content = shortcode($post->content);

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
        $category_id    = null;

        if (!empty($request->featured_image)) {
            $featured_image = ImageController::upload($request, 'featured_image');
        }
        if (!empty($request->category)) {
            $category_id = Category::where('name', $request->category)->first();
            if (!is_null($category_id)) {
                $category_id = $category_id->id;
            } else {
                $category_id = Category::create(['name' => $request->category]);
            }
        }
        
        $post->update([
            'title'             => $request->title,
            'content'           => $request->content,
            'featured_image'    => $featured_image,
            'link'              => titleToLink($request->title),
            'post_type'         => $request->post_type,
            'description'       => $request->description,
            'keywords'          => $request->keywords,
            'category_id'       => $category_id,
        ]);

        if (!empty($request->updatePublish)) {
            $post->status = 'published';
            $post->save();

            switch ($post->post_type) {
                case 'post':
                    PostPublished::dispatch($post);
                    runFunctionsOnPostEvent('post-publish', $post);
                    break;
                case 'page':
                    PagePublished::dispatch($post);
                    break;
                default:
                    PostPublished::dispatch($post);
                    runFunctionsOnPostEvent('post-publish', $post);
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

        addDashboardNotice('post_update', [
            'title' => 'Post updated',
            'message' => "Post '$post->title' has been updated.",
            'type' => 'info'
        ]);

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
                runFunctionsOnPostEvent('post-publish', $post);
                break;
            case 'page':
                PagePublished::dispatch($post);
                break;
            default:
                PostPublished::dispatch($post);
                runFunctionsOnPostEvent('post-publish', $post);
                break;
        }

        addDashboardNotice('post_update', [
            'title' => 'Post updated and published',
            'message' => "Post '$post->title' has been updated and published.",
            'type' => 'success'
        ]);

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

        addDashboardNotice('post_delete', [
            'title' => 'Post deleted',
            'message' => "Post '$post->title' has been deleted.",
            'type' => 'info'
        ]);

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
                    runFunctionsOnPostEvent('post-publish', $post);
                    break;
                case 'page':
                    PagePublished::dispatch($post);
                    break;
                default:
                    PostPublished::dispatch($post);
                    runFunctionsOnPostEvent('post-publish', $post);
                    break;
            }
        }

        addDashboardNotice('post_restore', [
            'title' => 'Post restored',
            'message' => "Post '$post->title' has been restored.",
            'type' => 'info'
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $post = Post::onlyTrashed()->where('id', $request->post);
        $postTitle = $post->first()->title;
        $post->forceDelete();

        addDashboardNotice('post_destroy', [
            'title' => 'Post destroyed',
            'message' => "Post '$postTitle' destroyed successfully.",
            'type' => 'info'
        ]);

        return redirect()->back();
    }
}
