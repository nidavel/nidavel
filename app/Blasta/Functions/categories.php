<?php

use App\Models\Category;

/**
 * Adds a category
 */
function addCategory(string $name)
{
    $ignored = [
        'post',
        'posts',
        'page',
        'pages',
        'upload',
        'uploads',
        'asset',
        'assets',
    ];

    if (in_array($name, $ignored)) {
        return false;
    }

    $category       = new Category;
    $category->name = $name;
    return $category->save();
}
