<?php

namespace Nidavel\Sitemap\Classes;

use Nidavel\Sitemap\Classes\SitemapType;
use Nidavel\Sitemap\Classes\UrlExports;

class Xml implements SitemapType
{
    public function generate(string $protocol, string $domain)
    {
        $urlExports = UrlExports::getInstance();
        $pages = $urlExports::getAllPages();
        
        try {
            $xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset>
</urlset>
XML;
            $sxe = new \SimpleXMLElement($xmlstr);
            $sxe->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            $sxe->addAttribute('\:xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');

            foreach ($pages as $index => $page) {
                $url = $sxe->addChild('url');
                $fullUrl = $protocol.'://'.$domain.str_replace('/index.html', '', $page['path']);
                $url->addChild('loc', $fullUrl);
                if (!empty($page['images'])) {
                    foreach ($page['images'] as $pageImage) {
                        $pageImage = str_replace('../', $protocol.'://'.$domain.'/', $pageImage);
                        $image = $url->addChild('\:image:image');
                        $image->addChild('\:image:loc', $pageImage);
                    }
                }
                $url->addChild('lastmod', \date('Y-m-d', $page['mtime']));
            }

            $dom = new \DOMDocument;
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($sxe->asXML());
            $xml = new \SimpleXMLElement($dom->saveXML());
            $xml->asXML(public_path('my_exports/sitemap.xml'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMappedUrls()
    {
        $sitemap = public_path('my_exports/sitemap.xml');

        if (!file_exists($sitemap)) {
            return null;
        }

        $xml = \file_get_contents($sitemap);
        $xml = new \SimpleXMLElement($xml);
        $urlset = $xml->children();
        $urls = [];

        foreach ($urlset as $url) {
            $urls[] = (string) $url->loc;
        }

        return $urls;
    }

    public function view()
    {
        $sitemap = public_path('my_exports/sitemap.xml');

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
        $content .= "Sitemap: $url/sitemap.xml\n";

        return $content;
    }
}
