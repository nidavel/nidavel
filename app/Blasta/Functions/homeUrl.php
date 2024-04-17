<?php

function homeUrl(string $url = '/', $level = -1) : string
{
    if ($level == -1) {
        $level = count(explode('/', $url)) - 1;
    }

    $url = trim($url, '.');
    $url = trim($url, '/');

    if ($_SERVER['SERVER_PORT'] == 8001) {
        if ($level == 0) {
            $url = './' . $url;
        }
        while ($level > 0) {
            $url = '../' . $url;
            $level--;
        }
    } else {
        $url = '/' . $url;
    }

    return $url;
}
