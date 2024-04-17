<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'exports/*',
        'exports/posts',
        'exports/post/*',
        'exports/page/*',
        '/posts/*',
        '/upload/*',
        '/uploads/*',
        '/menu/create',
        '/media/*',
        '/plugins/activate/*',
        '/plugins/deactivate/*',
        '/plugins/delete/*',
        '/widgets/*',
        '/settings/*',
        '/themes/*',
    ];
}
