<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts          = Post::latest()->take(5)->orderBy('id', 'DESC')->get();
        $postCount      = Post::where('post_type', 'post')->count();
        $pageCount      = Post::where('post_type', 'page')->count();
        $exportCount    = Export::count();

        return view('dashboard.index', [
            'posts'         => $posts,
            'postCount'     => $postCount,
            'pageCount'     => $pageCount,
            'exportCount'   => $exportCount
            ]
        );
    }

    /**
     * Renders a route's content on the content section
     * of the dashboard page.
     */
    static function RenderContent($route)
    {
        /* 
         * Create a token to use
         * and append to first URL
         */
        if (empty(request()->query('token'))) {
            $token = base64_encode(Hash::make($route));
            request()->query->add(['token' => $token]);
        }

        $port = env('APP_ENV') == 'production'
            ? ''
            : ':8001';
        
        $url = env('APP_URL') . $port . '/' . $route;

        /* 
         * Take every query in original URL
         * and append to this second URL
         */
        if (!empty(request()->query)) {
            $queries = '';
            foreach (request()->query as $query => $value){
                if ($query === 'token' || $query === 'route') {
                    continue;
                }
                $queries .= "$query=$value&";
            }
            $url .= "?$queries";
        }
        
        /* 
         * Send request with the already built second URL
         */
        $options = array(
            CURLOPT_URL             => $url,
            CURLOPT_ENCODING        => 'gzip',
            CURLOPT_RETURNTRANSFER  => true
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $contents = curl_exec($ch);
        curl_close($ch);

        return $contents;
    }
}
