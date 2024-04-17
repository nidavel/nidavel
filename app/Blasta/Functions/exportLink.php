<?php

function exportLink($url = '/', $level = -1)
{
    $link = homeUrl($url, $level);

    if ($_SERVER['SERVER_PORT'] == 8001
        && substr($url, 0, 4) != 'http') {
        $link .= '.html';
    }

    return $link;
}
