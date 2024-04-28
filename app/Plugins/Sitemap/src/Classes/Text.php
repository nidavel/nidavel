<?php

namespace Nidavel\Sitemap\Classes;

use Nidavel\Sitemap\Classes\SitemapType;
use Nidavel\Sitemap\Classes\UrlExports;

class Text implements SitemapType
{
    public function generate(string $protocol, string $domain)
    {
        $urlExports = UrlExports::getInstance();
        $pages = $urlExports::getAllPages();
        $urls = '';

        try {
            foreach ($pages as $index => $page) {
                $urls .= $protocol.'://'.$domain.str_replace('/index.html', '', $page['path'])."\n";
            }

            $fp = fopen(public_path('my_exports/sitemap.txt'), 'w');
            fwrite($fp, $urls);
            fclose($fp);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMappedUrls()
    {
        $sitemap = public_path('my_exports/sitemap.txt');

        if (!file_exists($sitemap)) {
            return null;
        }

        $txt = \file_get_contents($sitemap);
        $urls = [];

        $fp = fopen($sitemap, 'r');

        foreach (static::getAllLines($fp) as $line) {
            if ($line == "\n" || empty(trim($line))) {
                continue;
            }

            $urls[] = $line;
        }

        return $urls;
    }

    public function view()
    {
        $sitemap = public_path('my_exports/sitemap.txt');

        if (file_exists($sitemap)) {
            return file_get_contents($sitemap);
        }

        return null;
    }

    public function makeRobotsTxt()
    {
        $url = settings('r', 'general.protocol').'://'.settings('r', 'general.domain');

        $content = "# https://www.robotstxt.org/robotstxt.html\n";
        $content .= "User-agent: *\n";
        $content .= "Disallow:\n";
        $content .= "Sitemap: $url/sitemap.txt\n";

        return $content;
    }

    private static function getAllLines($fp)
    {
        while (!feof($fp)) {
            yield fgets($fp);
        }
    }
}
