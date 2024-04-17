<?php

function titleToLink(string $str): string
{
    $str = stripPunctuations($str);
    $str = stripIgnoredWords($str);
    $str = spaceToDash($str);
    $str = strtolower($str);

    return $str;
}

function linkToTitle(string $link): string
{
    $str = explode('/', $link);
    $str = $str[count($str) - 1];
    $str = ucfirst($str);
    $str = str_replace('-', ' ', $str);
    return $str;
}
