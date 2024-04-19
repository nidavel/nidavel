<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Returns a list of all pages
     */
    public function list()
    {
        $pagesFinal = [];
        $ignoredRoutes = [
            'pages/',
            'pages/{page}',
            'pages/list',
            'pages/all',
            'pages/all/published',
            'pages/all/drafts',
            'pages/all/trashed',
            'pages/all/{filter}',
            'pages/all/{page}'
        ];

        $pages = Post::where('post_type', 'page')
            ->where('status', 'published')
            ->get();
        $routes = Route::getRoutes();

        foreach ($pages as $page) {
            $pagesFinal[] = [
                'title' => $page->title,
                'link'  => $page->link ?? titleToLink($page->title)
            ];
        }
        
        foreach ($routes as $route) {
            $link = $route->uri();
            if (strpos($route->uri(), 'pages/') !== false) {
                if (in_array($route->uri(), $ignoredRoutes)) {
                    continue;
                }

                $pagesFinal = [...$pagesFinal, [
                    'title' => linkToTitle($link),
                    'link'  => $link
                    ]
                ];
            }
        }
        return $pagesFinal;
    }

    /**
     * Returns a list of all pages
     */
    public function listForSettings()
    {
        $pagesFinal = [];
        $ignoredRoutes = [
            'pages/',
            'pages/{page}',
            'pages/list',
            'pages/all',
            'pages/all/published',
            'pages/all/drafts',
            'pages/all/trashed',
            'pages/all/{filter}',
            'pages/all/{page}'
        ];

        $pages = Post::where('post_type', 'page')
            ->where('status', 'published')
            ->get();
        $routes = Route::getRoutes();
        $filePages = getFiles(front_path('/pages'));

        foreach ($pages as $page) {
            $pagesFinal[] = [
                'link'    => $page->id,
                'title' => $page->title
            ];
        }
        
        foreach ($routes as $route) {
            $link = $route->uri();
            if (strpos($route->uri(), 'pages/') !== false) {
                if (in_array($route->uri(), $ignoredRoutes)) {
                    continue;
                }

                $pagesFinal = [...$pagesFinal, [
                    'title' => linkToTitle($link),
                    'link'  => $link
                    ]
                ];
            }
        }

        foreach ($filePages as $file) {
            $link = rtrim($file, '.blade.php');
            $pagesFinal = [...$pagesFinal, [
                'title' => linkToTitle($link),
                'link'  => $link
                ]
            ];
        }

        if (!empty($pagesFinal)) {
            return $pagesFinal;
        }

        return null;
    }

    /**
     * Returns a list of all published pages
     */
    public function listPublished()
    {
        $pages = Post::where('post_type', 'page')
            ->where('status', 'published')
            ->get();
        
        return $pages;
    }

    /**
     * Returns a list of all routed pages
     */
    public function listRouted()
    {
        $pagesFinal = [];
        $ignoredRoutes = [
            'pages/',
            'pages/{page}',
            'pages/list',
            'pages/all',
            'pages/all/published',
            'pages/all/drafts',
            'pages/all/trashed',
            'pages/all/{filter}',
            'pages/all/{page}'
        ];
        $routes = Route::getRoutes();
        
        foreach ($routes as $route) {
            $link = $route->uri();
            if (strpos($route->uri(), 'pages/') !== false) {
                if (in_array($route->uri(), $ignoredRoutes)) {
                    continue;
                }

                $pagesFinal = [...$pagesFinal, [
                    'title' => linkToTitle($link),
                    'link'  => $link
                    ]
                ];
            }
        }

        return $pagesFinal;
    }

    /**
     * Display a listing of the resource in the dashboard.
     */
    public function all(Request $request)
    {
        $filter = $request->filter;
        $limit = 5;
        if (!isset($filter) || $filter === '') {
            $posts = Post::where('post_type', 'page')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=pages/all');
            $subtitle = 'All Pages';
        }

        else if ($filter === 'published') {
            $posts = Post::where('post_type', 'page')
                ->where('status', 'published')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=pages/all/published');
            $subtitle = 'Published Pages';
        }

        else if ($filter === 'drafts') {
            $posts = Post::where('post_type', 'page')
                ->where('status', 'draft')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=pages/all/drafts');
            $subtitle = 'Drafts';
        }

        else if ($filter === 'trashed') {
            $posts = Post::where('post_type', 'page')
                ->onlyTrashed()
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=pages/all/trashed');
            $subtitle = 'Trashed Pages';
        }
        
        else {
            $posts = Post::where('post_type', 'page')
                ->latest()
                ->orderBy('id', 'DESC')
                ->paginate($limit);
            $posts->withPath('/dashboard?route=pages/all');
            $subtitle = 'All Pages';
        }

        return view('dashboard.pages.index', [
            'posts'     => $posts,
            'subtitle'  => $subtitle
        ]);
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
    public function store(StorePageRequest $request)
    {
        //
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
            $post = Post::where('link', $queryString)
                ->where('post_type', 'page')
                ->firstOrFail();
        } else {
            $post = Post::where('id', (int) $queryString)
                ->where('post_type', 'page')
                ->firstOrFail();
        }

        $post->author = User::find($post->user_id)->name;

        return view('front.page', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
