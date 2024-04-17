<?php

/**
 * Creates a directory, and creates an index file in it
 */
function mkUriDir(string $path): bool
{
    if (!is_dir($path)) {
        if (!mkdir($path)) {
            return false;
        }
    }

    if (!file_exists("$path/index.html")) {
        $fp = fopen("$path/index.html", 'w');
        if (!fclose($fp)) {
            return false;
        }
    }

    return true;
}
