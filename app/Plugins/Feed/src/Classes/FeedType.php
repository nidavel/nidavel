<?php

namespace Nidavel\Feed\Classes;

use Nidavel\Feed\Classes\Feed;
use Nidavel\Feed\Classes\Atom;
use Nidavel\Feed\Classes\Rss;

class FeedType
{
    private static $instance = null;
    private static $feedType;
    private static $protocol;
    private static $domain;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new FeedType;
            static::$protocol = settings('r', 'general.protocol') ?? 'http';
            static::$domain = settings('r', 'general.domain') ?? '';
            static::$feedType = settings('r', 'feed.feed_type') ?? 'Feed';
            switch (static::$feedType) {
                case 'Feed':
                    static::$feedType = Feed::getInstance();
                    break;
                case 'Rss':
                    static::$feedType = Rss::getInstance();
                    break;
                case 'Atom':
                    static::$feedType = Atom::getInstance();
                    break;
                default:
                    static::$feedType = Feed::getInstance();
            }
        }
        return static::$instance;
    }

    public static function generate()
    {
        static::$feedType->generate(static::$protocol, static::$domain);
    }

    public static function view()
    {
        if (file_exists(public_path('my_exports/feed.xml'))) {
            return file_get_contents(public_path('my_exports/feed.xml'));
        }
        return '';
    }
}
