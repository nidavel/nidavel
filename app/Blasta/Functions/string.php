<?php

function toSnakeCase(string $delimiter, string $str): string
{
    return str_replace($delimiter, '_', $str);
}

function unSnakeCase(string $delimiter, string $str): string
{
    return str_replace('_', $delimiter, $str);
}

function spaceToDash(string $str, bool $trimSpaces = true) : string
{
    if ($trimSpaces === true) {
        $str = trim($str);
    }

    $str = str_replace(' ', '-', $str);

    return $str;
}

function dashToSpace(string $str, bool $trimSpaces = true) : string
{
    if ($trimSpaces === true) {
        $str = trim($str);
    }

    $str = str_replace('-', ' ', $str);

    return $str;
}

function toCamel(string $str, string $delim='_')
{
    $arr = str_split($str);
    $openDash = false;
    $newStr = '';

    foreach ($arr as $chr) {
        if ($chr === $delim) {
            $openDash = true;
            continue;
        }
        if ($openDash === true) {
            $chr = strtoupper($chr);
            $openDash = false;
        }
        $newStr .= $chr;
    }

    return $newStr;
}
