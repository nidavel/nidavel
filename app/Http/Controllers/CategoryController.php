<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return addCategory($request->name);
    }

    /**
     * Lists the published posts associated with given category.
     */
    public function list(Request $request)
    {
        $view;
        $query = url()->current();
        $query = explode('/', $query);
        $queryString = $query[count($query) - 1];

        if ($queryString != (int) $queryString) { // not int
            $id     = Category::where('name', $queryString)->first()->id;
            $posts  = Post::where('category_id', $id)
                ->where('status', 'published')
                ->get();
        } else {
            $posts  = Post::where('category_id', $queryString)->get();
        }

        if (file_exists(front_path('categories.blade.php'))) {
            $view = 'front.categories';
        } else {
            $view = 'front.posts';
        }

        return view($view, [
            'posts' => $posts
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $category   = request('category');
        $postQuery  = request('post');

        if ($postQuery != (int) $postQuery) {
            $post = Post::where('link', $postQuery)
                ->where('status', 'published')
                ->firstOrFail();
        } else {
            $post = Post::where('id', $postQuery)
                ->where('status', 'published')
                ->firstOrFail();
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
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
