<?php

/**
 * A download function that gets a file from a url
 * and saves it in a given location
 */
function download(string $url, string $storageLocation): bool
{
    $filename = basename($url); 
      
    if (file_put_contents("$storageLocation/$filename", file_get_contents($url))) { 
        return true;
    }
    
    return false;
}

/**
 * Download a plugin from url
 */
function downloadPlugin(string $url): bool
{
    return download($url, plugin_path());
}

/**
 * Download a theme from url
 */
function downloadTheme(string $url): bool
{
    return download($url, theme_path());
}


/**
 * An extract function to extract zipped file to a given location
 */
function extractFile(string $zipped, string $location): bool
{
    $zip = new ZipArchive;
    $filename = basename($zipped);

    $res = $zip->open($zipped);

    if ($res === true) {
        $zip->extractTo("$location");
        $zip->close();
        return true;
    } else {
        return false;
    }
}

/**
 * Extract downloaded plugin
 */
function extractPlugin(string $zipped): bool
{
    return extractFile($zipped, plugin_path());
}

/**
 * Extract downloaded theme
 */
function extractTheme(string $zipped): bool
{
    return extractFile($zipped, theme_path());
}

/**
 * Deletes zipped file
 */
function deleteZipped(string $filename): bool
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $filename);
    finfo_close($finfo);

    if ($mimeType === 'application/zip' || $mimeType === 'application/x-rar-compressed') {
        return unlink($filename);
    }

    return false;
}

/**
 * Deletes zipped plugin
 */
function deleteZippedPlugin(string $filename): bool
{
    return deleteZipped(plugin_path("/$filename"));
}

/**
 * Deletes zipped theme
 */
function deleteZippedTheme(string $filename): bool
{
    return deleteZipped(theme_path("/$filename"));
}
