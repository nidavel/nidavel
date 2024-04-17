<?php

function dirPath(string $file = __FILE__) : string
{
    return dirname($file);
}

function front_path(string $resource = '', bool $trailingSlash = false) : string
{
    $resource = '/' . ltrim($resource, '/');
    $path = base_path() . '/resources/views/front' . $resource;
    $path .= $trailingSlash === true ? '/' : '';
    $path = str_replace('\\', '/', $path);
    return $path;
}

function plugin_path(string $resource = '', bool $trailingSlash = false): string
{
    $resource = '/' . ltrim($resource, '/');
    $path = base_path() . '/app/Plugins' . $resource;
    $path .= $trailingSlash === true ? '/' : '';
    $path = str_replace('\\', '/', $path);
    return $path;
}

function theme_path(string $resource = '', bool $trailingSlash = false): string
{
    $resource = '/' . ltrim($resource, '/');
    $path = base_path() . '/app/Themes' . $resource;
    $path .= $trailingSlash === true ? '/' : '';
    $path = str_replace('\\', '/', $path);
    return $path;
}
