<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
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
        $category = new Category;
        $category->name = $request->name;
        return $category->save();
    }

    /**
     * Lists the posts associated with given category.
     */
    public function list(Request $request)
    {
        $query = url()->current();
        $query = explode('/', $query);
        $queryString = $query[count($query) - 1];

        if ($queryString != (int) $queryString) { // not int
            $id     = Category::where('name', $queryString)->first()->id;
            $posts  = Post::where('category_id', $id)->get();
        } else {
            $posts  = Post::where('category_id', $queryString)->get();
        }

        return view('front.categories', [
            'posts' => $posts
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(category $category, Request $request)
    {
        $query = url()->current();
        $query = explode('/', $query);
        $queryString = $query[count($query) - 1];
        dd(request());

        if ($queryString != (int) $queryString) { // not int
            // $id     = Category::where('name', $queryString)->first();
            // $category = Category
            $post   = Post::where('category_id', $id)->get();
        } else {
            $post  = Post::where('category_id', $queryString)->get();
        }

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
