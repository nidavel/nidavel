<?php

function stripPunctuations(string $str) : string
{
    $punctuations = [
        '.', ',', '!',
        '/', ':', ';',
        '\'', '"', '[',
        '{', '}', ']',
        '`', '~', '$',
        '^', '&', '*',
        '=', '(', ')',
        '?', '\\'
    ];

    foreach ($punctuations as $punctuation) {
        $str = str_replace($punctuation, '', $str);
    }

    return $str;
}
