<?php
namespace Nidavel\Feed\Classes;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Nidavel\Feed\Classes\SimpleXMLExtended;

class Atom
{
    private static $instance = null;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new Atom;
        }
        return static::$instance;
    }

    public static function generate(string $protocol, string $domain)
    {
        $posts = Post::where('status', 'published')
            ->orderBy('id', 'DESC')
            ->get();
        $language = !empty(settings('r', 'general.language'))
            ? settings('r', 'general.language')
            : 'en-US';
        
        try {
            $xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="$language">
</feed>
XML;
            $sxe = new SimpleXMLExtended($xmlstr);
            
            $sxe->addChild('title', settings('r', 'general.name') ?? 'Nidavel');
            $link = $sxe->addChild('link');
            $link->addAttribute('href', "$protocol://$domain");
            $link->addAttribute('rel', 'self');
            $sxe->addChild(
                'subtitle',
                !empty(settings('r', 'general.description'))
                ? settings('r', 'general.description')
                : 'Website made with Nidavel'
            );
            
            $sxe->addChild('updated', \date(DATE_ATOM, time()));

            $author = $sxe->addChild('author');
            $author->addChild('name', User::find(1)->name);
            $author->addChild('email', User::find(1)->email);

            $sxe->addChild('icon', "$protocol://$domain/favicon.ico");
            $sxe->addChild('id', "$protocol://$domain/");

            foreach ($posts as $post) {
                $entry = $sxe->addChild('entry');
                $category = null;
                $subCategory = '';

                $entry->addChild('title', $post->title);
                $entry->addChild('published', \date(DATE_ATOM, strtotime($post->created_at)));

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
                $content = $entry->addChild('content');
                $content->addAttribute('type', 'html');
                $content->addCData('<a href="'.$fullUrl.'"><img alt="'.$post->title.'" src="'.$protocol.'://'.$domain.homeUrl('uploads/' . $post->featured_image, 1).'"/></a>');
                $link = $entry->addChild('link');
                $link->addAttribute('href', $fullUrl);
                $link->addAttribute('rel', 'self');
                $postAuthor = $entry->addChild('author');
                $postAuthor->addChild('name', User::find($post->user_id)->name);
                $postAuthor->addChild('email', User::find($post->user_id)->email);
                $entry->addChild('summary', $post->description);
                $cat = $entry->addChild('category');
                $cat->addAttribute('term', $category);
                $entry->addChild('updated', \date(DATE_ATOM, strtotime($post->created_at)));
                $entry->addChild('id', $fullUrl);
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
