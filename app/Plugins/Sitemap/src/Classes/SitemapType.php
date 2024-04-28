<?php

namespace Nidavel\Sitemap\Classes;

interface SitemapType
{
    public function generate(string $protocol, string $domain);

    public function getMappedUrls();

    public function makeRobotsTxt();

    function view();
}
