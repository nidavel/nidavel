<?php
namespace Nidavel\Feed\Classes;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Nidavel\Feed\Classes\SimpleXMLExtended;

class Feed
{
    private static $instance = null;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new Feed;
        }
        return static::$instance;
    }

    public static function generate(string $protocol, string $domain)
    {
        $posts = Post::where('status', 'published')
            ->orderBy('id', 'DESC')
            ->get();
        
        try {
            $xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" xmlns:georss="http://www.georss.org/georss" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#">
</rss>
XML;
            $sxe = new SimpleXMLExtended($xmlstr);
            
            $channel = $sxe->addChild('channel');
            $channel->addChild('title', settings('r', 'general.name') ?? 'Nidavel');
            $atomLink = $channel->addChild('\:atom:link');
            $atomLink->addAttribute('rel', 'self');
            $atomLink->addAttribute('href', "$protocol://$domain");
            $atomLink->addAttribute('type', 'application/rss+xml');
            $channel->addChild('link', "$protocol://$domain");
            $channel->addChild(
                'description',
                !empty(settings('r', 'general.description'))
                ? settings('r', 'general.description')
                : 'Website made with Nidavel');
            $channel->addChild(
                'language',
                !empty(settings('r', 'general.language'))
                ? settings('r', 'general.language')
                : 'en-US'
            );
            $channel->addChild('lastBuildDate', \date(DATE_RSS, time()));
            $channel->addChild('\:sy:updatePeriod', 'hourly');
            $channel->addChild('\:sy:updateFrequency', '1');
            $channel->addChild('generator', 'https://nidavel.com');

            $image = $channel->addChild('image', settings('r', 'general.site_logo'));
            $image->addChild('title', settings('r', 'general.name'));
            $image->addChild('link', "$protocol://$domain");
            $image->addChild(
                'url',
                !empty(settings('r', 'general.logo_url'))
                ? settings('r', 'general.logo_url')
                : 'https://nidavel.com/android-chrome-192x192.png'
            );
            $image->addChild('width', '144');
            $image->addChild('height', '124');

            $item = $channel->addChild('item');

            foreach ($posts as $post) {
                $category = null;
                $subCategory = '';

                $item->addChild('title', $post->title);
                $item->addChild('pubDate', \date(DATE_RSS, strtotime($post->created_at)));
                $dcCreator = $item->addChild('\:dc:creator');
                $dcCreator->addCData(settings('r', 'general.name'));

                if (is_null($post->category) && ($post->post_type === 'post')) {
                    $category = 'post';
                    $categoryParameter = 'posts';
                }
                else if (!is_null($post->category)) {
                    $category = Category::find($post->category)->name;
                    $categoryParameter = $post->category;
                }
                else {
                    $category = $post->post_type;
                    $categoryParameter = $post->post_type === 'post'
                        ? 'posts'
                        : 'pages';
                }

                if (!is_null($post->subcategory)) {
                    $subcategory = "$post->subcategory/";
                }

                $fullUrl = "$protocol://$domain/$categoryParameter/$subCategory"."$post->link.html";
                $item->addChild('link', $fullUrl);
                $description = $item->addChild('description');
                $description->addCData($post->description);
                $cat = $item->addChild('category');
                $cat->addCData($category);
                $item->addChild('comments', 'https://comments.nidavel.com/'.settings('r', 'site.property_id')."/$post->id");
                $item->addChild('\:slash:comments', '0');
                $guid = $item->addChild('guid', "$fullUrl/");
            }

            $dom = new \DOMDocument;
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($sxe->asXML());
            $xml = new \SimpleXMLElement($dom->saveXML());
            $xml->asXML(public_path('my_exports/feed.xml'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
