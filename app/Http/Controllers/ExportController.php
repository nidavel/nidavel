<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Export;
use App\Models\Post;
use App\Http\Requests\StoreExportRequest;
use App\Http\Requests\UpdateExportRequest;
// use Session;


class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.exports.index');
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
    public function store(StoreExportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Export $export)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Export $export)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExportRequest $request, Export $export)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Export $export)
    {
        //
    }

    /**
     * Display a listing of the resource in the dashboard.
     */
    public function all(Request $request)
    {
        $filter = $request->filter;
        $exportPath = public_path('my_exports');
        $exports = [];
        $subtitle = '';
        
        if (!isset($filter) || $filter === '') {
            $exports = getContents("$exportPath/posts");
            $subtitle = 'Posts';
        }

        else if ($filter === 'homepage') {
            $exports = file_exists("$exportPath/index.html") ? ['index.html'] : null;
            $subtitle = 'Homepage';
        }

        else if ($filter === 'pages') {
            $exports = getContents("$exportPath/pages");
            $subtitle = 'Pages';
        }

        else {
            $exports = getContents("$exportPath/posts");
            $subtitle = 'Posts';
        }

        return view('dashboard.exports.index', [
            'exports'     => $exports,
            'subtitle'  => $subtitle
        ]);
    }

    /**
     * Exports the current homepage
     */
    public function exportHomepage()
    {
        if (!file_exists(public_path() . '/my_exports')) {
            mkdir(public_path() . '/my_exports');
        }

        $fp = fopen("my_exports/index.html", 'w');

        $port = env('APP_ENV') == 'production'
            ? ''
            : ':8001';
        
        $options = array(
            CURLOPT_URL             => env('APP_URL') . $port . '/',
            CURLOPT_ENCODING        => 'gzip',
            CURLOPT_RETURNTRANSFER  => true
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = curl_exec($ch);
        curl_close($ch);

        fwrite($fp, $res);
        fclose($fp);

        return redirect()->back();
    }

    /**
     * Exports a single post
     */
    public function exportPost(Post $post, $postType = 'post')
    {
        if (is_string(request()->post)) {
            $id = request()->post;
        } else if (isset($post->id)) {
            $id = $post->id;
        }
        else {
            $id = request()->post->id;
        }

        switch ($postType) {
            case 'post':
                $subdirectory = 'posts';
                break;
            case 'page':
                $subdirectory = 'pages';
                break;
            default:
                $subdirectory = 'posts';
        }

        if ($post->status !== "published") {
            session()->flash("error", "Post must be published");
            return redirect()->back();
        }

        if ($post->deleted_at !== null) {
            session()->flash("error", "Deleted post can not be exported");
            return redirect()->back();
        }

        if (!file_exists(public_path() . '/my_exports')) {
            mkdir(public_path() . '/my_exports');
        }

        if (!file_exists(public_path() . '/my_exports/'.$subdirectory)) {
            mkdir(public_path() . '/my_exports/'.$subdirectory);
        }

        $link = $post->link == null
            ? titleToLink($post->title)
            : $post->link;

        $fp = fopen("my_exports/$subdirectory/$link" . '.html', 'w');

        $port = config('app.env') == 'production'
            ? ''
            : ':8001';
        
        $options = array(
            CURLOPT_URL             => env('APP_URL') . $port . '/'.$subdirectory.'/' . $id,
            CURLOPT_ENCODING        => 'gzip',
            CURLOPT_RETURNTRANSFER  => true
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = curl_exec($ch);
        curl_close($ch);

        fwrite($fp, $res);
        fclose($fp);

        return redirect()->back();
    }

    /**
     * Exports a single page
     */
    public function exportPage(Post $post)
    {
        $this->exportPost($post, 'page');
        return redirect()->back();
    }

    /**
     * Exports all posts
     */
    public function exportPosts()
    {
        $posts = Post::where('status', 'published')
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($posts as $post) {
            $id = $post->id;

            if ($post->deleted_at !== null) {
                session()->flash('error', 'Deleted post can not be exported');
                return redirect()->back();
            }

            if (!file_exists(public_path('/my_exports'))) {
                mkdir(public_path('/my_exports'));
            }

            if (!file_exists(public_path('/my_exports/posts'))) {
                mkdir(public_path('/my_exports/posts'));
            }

            $link = $post->link == null
                ? titleToLink($post->title)
                : $post->link;

            $fp = fopen("my_exports/posts/$link" . '.html', 'w');

            $port = config('app.env') == 'production'
                ? ''
                : ':8001';
            
            $options = array(
                CURLOPT_URL             => env('APP_URL') . $port . '/posts/' . $id,
                CURLOPT_ENCODING        => 'gzip',
                CURLOPT_RETURNTRANSFER  => true
            );
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            $res = curl_exec($ch);
            curl_close($ch);

            fwrite($fp, $res);
            fclose($fp);
        }

        return redirect()->back();
    }

    /**
     * Deletes the specified exported post
     */
    public function deletePost(Post $post, $postType = 'post')
    {
        switch ($postType) {
            case 'post':
                $subdirectory = 'posts';
                break;
            case 'page':
                $subdirectory = 'pages';
                break;
            default:
                $subdirectory = 'posts';
        }

        $path = base_path("/public/my_exports/$subdirectory/$post->link.html");

        if (file_exists($path)) {
            unlink($path);
        }

        return redirect()->back();
    }

    /**
     * Deletes the specified exported page
     */
    public function deletePage(Post $post)
    {
        $this->deletePost($post, 'page');
    }

    /**
     * Deletes the specified export by name
     */
    public function deleteExport(Request $request)
    {
        $subdirectory = $request->subdirectory !== 'homepage' ? "$request->subdirectory/" : '';
        
        unlink(public_path("/my_exports/$subdirectory".$request->export));

        return redirect()->back();
    }

    /**
     * Clears all orphaned posts and pages
     */
    public function clearOrphaned(Request $request)
    {
        $posts = Post::where('post_type', 'post')
            ->get('link');
        $postLinks = [];
        foreach ($posts as $post) {
            $postLinks[] = titleToLink($post->link);
        }
        $exportedPosts = getFiles(public_path("/my_exports/posts"));

        $pages = Post::where('post_type', 'page')
            ->get('link');
        $pageLinks = [];
        foreach ($pages as $page) {
            $pageLinks[] = titleToLink($page->link);
        }
        $exportedPages = getFiles(public_path("/my_exports/pages"));

        foreach ($exportedPosts as $exportedPost) {
            if (!in_array(substr($exportedPost, 0, strpos($exportedPost, '.html')), $postLinks)) {
                unlink(public_path("/my_exports/posts/$exportedPost"));
            }
        }

        foreach ($exportedPages as $exportedPage) {
            if (!in_array(rtrim($exportedPage, '.html'), $pageLinks)) {
                unlink(public_path("/my_exports/pages/$exportedPage"));
            }
        }

        return redirect()->back();
    }

    /**
     * Exports the specified assets
     */
    public function exportAssets()
    {
        exportAssets();
    }
}
