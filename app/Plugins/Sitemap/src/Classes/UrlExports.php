<?php

namespace Nidavel\Sitemap\Classes;

class UrlExports
{
    private static $home;
    private static $instance;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new UrlExports;
            static::$home = public_path('my_exports');
        }

        return static::$instance;
    }

    public static function getIndex()
    {
        if (file_exists(static::$home."/index.html")) {
            return static::$home."/index.html";
        }

        return null;
    }

    public static function getAllpages()
    {
        $contents = [];
        $ignored = settings('r', 'sitemap.ignored_urls');

        $f_filter = fn ($o_file) => $o_file->getFilename() == '.git'
            || $o_file->getFilename() == 'assets'
            || $o_file->getFilename() == 'uploads'
            || strpos($ignored, \basename(\dirname($o_file->getPathname())).'/'.$o_file->getFilename()) > 0
                ? false
                : true;

        $dir = new \RecursiveDirectoryIterator(static::$home, \RecursiveDirectoryIterator::SKIP_DOTS);
        $o_filter = new \RecursiveCallbackFilterIterator($dir, $f_filter);
        $files = new \RecursiveIteratorIterator($o_filter, \RecursiveIteratorIterator::CHILD_FIRST);
        $i = 0;
        
        foreach ($files as $fileinfo) {
            $imgs = [];
            $fileHandle;
            $filename = $fileinfo->getFilename();
            $filesize = $fileinfo->getSize();
            $filetype = $fileinfo->getExtension();
            if ($filetype == 'html' && $filesize > 0) {
                $path = $fileinfo->getPathname();
                $fileHandle = $path;
                $path = substr($path, strpos($path, 'my_exports'));
                $path = trim($path, 'my_exports');
                $path = str_replace('\\', '/', $path);
                $contents[$i]['path'] = $path;
                $contents[$i]['mtime'] = $fileinfo->getMTime();

                $fp = fopen($fileHandle, 'r');

                foreach (static::getAllLines($fp) as $line) {
                    $imgUrl = '';
                    $str = [];
                    if (!strpos($line, '<img')) {
                        continue;
                    }
                    preg_match('/src=\".+\"/', $line, $matches);
                    $str = $matches[0];
                    for ($x=0, $y=0; $x<2; $y++) {
                        if ($str[$y] == '"') {
                            $x++;
                            continue;
                        }
                        
                        if ($x < 1) {
                            continue;
                        }

                        $imgUrl .= $str[$y];
                    }
                    $imgs[] = $imgUrl;
                }
                $contents[$i]['images'] = $imgs;

                $i++;
            }
        }

        return $contents;
    }

    private static function getAllLines($fp)
    {
        while (!feof($fp)) {
            yield fgets($fp);
        }
    }
}
