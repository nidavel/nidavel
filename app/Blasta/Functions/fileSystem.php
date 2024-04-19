<?php

/**
 * Returns a list of directory contents in a directory
 */
function getContents(string $dir)
{
    $contents = [];
    $dir = new DirectoryIterator($dir);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $contents[] = $fileinfo->getFileName();
        }
    }

    return $contents;
}

/**
 * Returns a list of directory contents in a directory
 * except given
 */
function getContentsExcept(string $dir, ?string $except = null)
{
    $contents = [];
    $dir = new DirectoryIterator($dir);
    foreach ($dir as $fileinfo) {
        $filename = $fileinfo->getFilename();
        if (!$fileinfo->isDot() && $filename !== $except) {
            $contents[] = $filename;
        }
    }

    return $contents;
}

/**
 * Returns a list of directory names in a directory
 */
function getDirectories(string $dir)
{
    $dirs = [];
    $dir = new DirectoryIterator($dir);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot() && $fileinfo->isDir()) {
            $dirs[] = $fileinfo->getFileName();
        }
    }

    return $dirs;
}

/**
 * Returns a list of file names in a directory
 */
function getFiles(string $dir)
{
    $files = [];
    if (!file_exists($dir)) {
        return $files;
    }
    
    $dir = new DirectoryIterator($dir);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot() && $fileinfo->isFile()) {
            $files[] = $fileinfo->getFileName();
        }
    }

    return $files;
}

/**
 * Deletes a directory
 */
function deleteDir(string $path, bool $recursive = false)
{
    if ($recursive === false) {
        return rmdir($path);
    }

    return rrmdir($path);
}

/**
 * Recursively deletes a directory
 */
function rrmdir($path)
{
    if (!file_exists($path)) {
        return;
    }
    
    $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it,
                 RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
        if ($file->isDir()){
            rmdir($file->getPathname());
        } else {
            unlink($file->getPathname());
        }
    }
    rmdir($path);
}

/**
 * Recursively copies the contents of a directory
 */
function rCopy(
    string $sourceDirectory,
    string $destinationDirectory,
    string $childFolder = ''
): void
{
    $directory = opendir($sourceDirectory);

    if (is_dir($destinationDirectory) === false) {
        mkdir($destinationDirectory);
    }

    if ($childFolder !== '') {
        if (is_dir("$destinationDirectory/$childFolder") === false) {
            mkdir("$destinationDirectory/$childFolder");
        }

        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir("$sourceDirectory/$file") === true) {
                rCopy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            } else {
                copy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            }
        }

        closedir($directory);

        return;
    }

    while (($file = readdir($directory)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_dir("$sourceDirectory/$file") === true) {
            rCopy("$sourceDirectory/$file", "$destinationDirectory/$file");
        }
        else {
            copy("$sourceDirectory/$file", "$destinationDirectory/$file");
        }
    }

    closedir($directory);
}
