<?php

namespace Nidavel\Sitemap\Classes;

use Nidavel\Sitemap\Classes\Xml;
use Nidavel\Sitemap\Classes\Text;
use Nidavel\Sitemap\Classes\SitemapType;

class Sitemap
{
    private static $instance;
    private static $protocol;
    private static $domain;
    private static string $sitemapType;
    private static SitemapType $sitemap;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new Sitemap;
            static::$protocol = settings('r', 'general.protocol') ?? '';
            static::$domain = settings('r', 'general.domain') ?? '';
            static::$sitemapType = settings('r', 'sitemap.sitemap_type') ?? 'xml';
            switch (static::$sitemapType) {
                case 'xml':
                    static::$sitemap = new Xml;
                    break;
                case 'text':
                    static::$sitemap = new Text;
                    break;
                default:
                    static::$sitemap = new Xml;
            }
        }

        return static::$instance;
    }

    public static function generate()
    {
        static::$sitemap->generate(static::$protocol, static::$domain);

        if (settings('r', 'sitemap.create_robots') == 'checked') {
            static::makeRobotsTxt();
        }
    }

    public static function getMappedUrls()
    {
        return static::$sitemap->getMappedUrls();
    }

    public static function ignore(string $url)
    {
        $ignoredUrls = static::getIgnored();
        
        if (\in_array($url, $ignoredUrls)) {
            return;
        }

        settings('a', 'sitemap.ignored_urls', "'$url");

        static::generate();

        return;
    }

    public static function unignore(string $url)
    {
        $ignoredUrls = static::getIgnored();
        
        if (!\in_array($url, $ignoredUrls)) {
            return;
        }

        $urls = settings('r', 'sitemap.ignored_urls');
        $urls = str_replace("'$url", "", $urls);

        settings('w', 'sitemap.ignored_urls', "$urls");

        static::generate();

        return;
    }

    public static function getIgnored()
    {
        $ignoredUrls = ltrim(settings('r', 'sitemap.ignored_urls'), "'");
        $ignoredUrls = \explode("'", $ignoredUrls);

        return $ignoredUrls;
    }

    public static function view()
    {
        return static::$sitemap->view();
    }

    public static function makeRobotsTxt()
    {
        $robotsTxt = public_path('my_exports/robots.txt');

        $robots = static::$sitemap->makeRobotsTxt();

        $fp = fopen($robotsTxt, 'w');
        fwrite($fp, $robots);
        fclose($fp);
    }
}
