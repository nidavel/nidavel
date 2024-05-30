<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Export;
use App\Models\Post;
use App\Models\Category;
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
            mkUriDir(public_path() . '/my_exports');
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

        if (!is_null($post->category_id)) {
            $subdirectory = Category::find($post->category_id)->name;
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
            mkUriDir(public_path() . '/my_exports');
        }

        if (!file_exists(public_path() . '/my_exports/'.$subdirectory)) {
            mkUriDir(public_path() . '/my_exports/'.$subdirectory);
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
            ->where('post_type', 'post')
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($posts as $post) {
            $id = $post->id;
            $subdirectory = 'posts';

            if ($post->deleted_at !== null) {
                session()->flash('error', 'Deleted post can not be exported');
                return redirect()->back();
            }

            if (!file_exists(public_path('/my_exports'))) {
                mkUriDir(public_path('/my_exports'));
            }

            if (!file_exists(public_path('/my_exports/posts'))) {
                mkUriDir(public_path('/my_exports/posts'));
            }

            if ($post->category_id != null) {
                $subdirectory = Category::find($post->category_id)->name;
                if (!file_exists(public_path("/my_exports/$subdirectory"))) {
                    mkUriDir(public_path("/my_exports/$subdirectory"));
                }
            }

            $link = $post->link == null
                ? titleToLink($post->title)
                : $post->link;

            $fp = fopen("my_exports/$subdirectory/$link" . '.html', 'w');

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
     * Exports post pages
     */
    public function exportPages()
    {
        $posts = Post::where('status', 'published')
            ->where('post_type', 'page')
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($posts as $post) {
            $id = $post->id;
            $subdirectory = 'pages';

            if ($post->deleted_at !== null) {
                session()->flash('error', 'Deleted post can not be exported');
                return redirect()->back();
            }

            if (!file_exists(public_path('/my_exports'))) {
                mkUriDir(public_path('/my_exports'));
            }

            if (!file_exists(public_path('/my_exports/pages'))) {
                mkUriDir(public_path('/my_exports/pages'));
            }

            if ($post->category_id != null) {
                $subdirectory = Category::find($post->category_id)->name;
                if (!file_exists(public_path("/my_exports/$subdirectory"))) {
                    mkUriDir(public_path("/my_exports/$subdirectory"));
                }
            }

            $link = $post->link == null
                ? titleToLink($post->title)
                : $post->link;

            $fp = fopen("my_exports/$subdirectory/$link" . '.html', 'w');

            $port = config('app.env') == 'production'
                ? ''
                : ':8001';
            
            $options = array(
                CURLOPT_URL             => env('APP_URL') . $port . '/pages/' . $id,
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

        $this->exportFilePages();

        return redirect()->back();
    }

    /**
     * Exports file pages
     */
    public function exportFilePages()
    {
        $filePages = getFiles(front_path('/pages'));

        if (!file_exists(public_path('/my_exports'))) {
            mkUriDir(public_path('/my_exports'));
        }

        if (!file_exists(public_path('/my_exports/pages'))) {
            mkUriDir(public_path('/my_exports/pages'));
        }

        foreach ($filePages as $page) {
            $link = rtrim($page, '.blade.php');
            $link = spaceToDash($link);

            $fp = fopen("my_exports/pages/$link" . '.html', 'w');

            $port = config('app.env') == 'production'
                ? ''
                : ':8001';
            
            $options = array(
                CURLOPT_URL             => env('APP_URL') . $port . '/pages/' . $link,
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
        $subdirectory = 'posts';

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

        if ($post->category_id != null) {
            $subdirectory = Category::find($post->category_id)->name;
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
        $posts          = Post::all();
        $postLinks      = [];
        $pageLinks      = [];
        $categories     = [];
        $exportedPosts  = getFiles(public_path("/my_exports/posts"));
        $exportedPages  = getFiles(public_path("/my_exports/pages"));

        foreach ($posts as $post) {
            if ($post->deleted_at != null) {
                continue;
            }
            if ($post->category_id != null) {
                $category = Category::find($post->category_id)->name;
                $categories[$category] = titleToLink($post->link);
                continue;
            }
            if ($post->post_type == 'post') {
                $postLinks[] = titleToLink($post->link);
                continue;
            }
            if ($post->post_type == 'page') {
                $pageLinks[] = titleToLink($post->link);
                continue;
            }
        }

        $this->clearOrphanedPosts($exportedPosts, $postLinks);

        $this->clearOrphanedPages($exportedPages, $pageLinks);

        $this->clearOrphanedCategories($categories);

        return redirect()->back();
    }

    /**
     * Exports the specified assets
     */
    public function exportAssets()
    {
        exportAssets();
    }

    private function clearOrphanedPosts($postExports, $dbPostLinks)
    {
        foreach ($postExports as $exportedPost) {
            if ($exportedPost === 'index.html') {
                continue;
            }
            if (!in_array(substr($exportedPost, 0, strpos($exportedPost, '.html')), $dbPostLinks)) {
                unlink(public_path("/my_exports/posts/$exportedPost"));
            }
        }
    }

    private function clearOrphanedPages($pageExports, $dbPageLinks)
    {
        foreach ($pageExports as $exportedPage) {
            if ($exportedPage === 'index.html') {
                continue;
            }
            if (!in_array(rtrim($exportedPage, '.html'), $dbPageLinks)) {
                unlink(public_path("/my_exports/pages/$exportedPage"));
            }
        }
    }

    private function clearOrphanedCategories($categoryExports)
    {
        foreach ($categoryExports as $name => $links) {
            $exportedLinks = getFiles(public_path("/my_exports/$name"));
            foreach ($exportedLinks as $exportedLink) {
                if ($exportedLink == 'index.html') {
                    continue;
                }
                if (is_string($links)) {
                    $links = [$links];
                }
                if (!in_array(rtrim($exportedLink, '.html'), $links)) {
                    unlink(public_path("/my_exports/$name/$exportedLink"));
                }
            }
        }
    }
}
