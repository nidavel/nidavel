<?php

/**
 * Loads the active themes index
 * which is the entry point for the theme's functionalities
 */
function loadActiveThemeIndex()
{
    require_once base_path('/resources/views/front/index.php');
}

/**
 * Returns the names of all installed themes
 */
function getInstalledThemes()
{
    return getDirectories(theme_path());
}

/**
 * Check if theme exists
 */
function themeExists(string $themeName): bool
{
    $theme = theme_path("/$themeName");

    if (file_exists($theme)) {
        return true;
    }

    return false;
}

/**
 * Returns the screenshot path of all installed themes
 */
function getThemeScreenshot(string $themeName): ?string
{
    $defaultScreenshot = theme_path('/screenshot.jpg');
    if (!themeExists($themeName)) {
        return null;
    }

    $screenshot = theme_path("/$themeName/screenshot.jpg");

    return file_exists($screenshot) ? $screenshot : $defaultScreenshot;
}

/**
 * Returns the name of the active theme
 */
function getActiveTheme()
{
    $details = json_decode(file_get_contents(front_path('/details.json')));
    return $details->name;
}

/**
 * Fetch available free themes from an online repository
 */
function fetchFreeThemes()
{
    $url = 'http://localhost:5000/api/v0/free';
    return fetch($url);
}

/**
 * Searches based on query, for an available free theme on an online repository
 */
function searchFreeThemes(string $query)
{
    $url = "http://localhost:5000/api/v0/search-free/$query";
    return fetch($url);
}

/**
 * Activates a theme
 */
function activateTheme(string $themeName)
{
    // $themeDir = resource_path("/views/theme");
    $themeDir = front_path();
    $selectedTheme = theme_path("/$themeName");

    if (!file_exists("$selectedTheme/details.json")) {
        return;
    }

    $themeDirContents = new DirectoryIterator($themeDir);
    foreach ($themeDirContents as $fileinfo) {
        if ($fileinfo->isDot()) {
            continue;
        }
        if ($fileinfo->isDir()) {
            deleteDir($themeDir.'/'.$fileinfo->getFileName(), true);
        }
        if ($fileinfo->isFile()) {
            unlink($themeDir.'/'.$fileinfo->getFileName());
        }
    }

    // Delete active theme directory contents
    $it = new RecursiveDirectoryIterator($themeDir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it,
                 RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
        if ($file->isDir()){
            rmdir($file->getPathname());
        } else {
            unlink($file->getPathname());
        }
    }

    // Copy files to active theme directory
    $selectedThemeDir = new DirectoryIterator($selectedTheme);
    foreach ($selectedThemeDir as $fileinfo) {
        if ($fileinfo->isDot()) {
            continue;
        }
        if ($fileinfo->isDir()) {
            rCopy($selectedTheme.'/'.$fileinfo->getFileName(), $themeDir.'/'.$fileinfo->getFileName());
        }
        if ($fileinfo->isFile()) {
            copy($selectedTheme.'/'.$fileinfo->getFileName(), $themeDir.'/'.$fileinfo->getFileName());
        }
    }

    exportAssets();
}
