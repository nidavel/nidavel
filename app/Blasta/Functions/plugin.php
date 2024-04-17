<?php

/**
 * Returns the names of all installed plugins
 */
function getPlugins()
{
    return getDirectories(plugin_path());
}

/**
 * Returns the details of an installed plugin
 */
function getPluginDetails(string $pluginName, bool $assoc = false)
{
    $details = file_get_contents(plugin_path("/$pluginName/details.json"));

    return json_decode($details, $assoc);
}

/**
 * Checks if plugin exists
 */
function pluginExists(string $pluginName): bool
{
    $plugin = plugin_path("/$pluginName");

    if (file_exists($plugin)) {
        return true;
    }

    return false;
}

/**
 * Marks a plugin as active
 */
function markPluginActive(string $pluginName)
{
    if (!pluginExists($pluginName)) {
        throw new Exception("Plugin $pluginName does not exist.");
    }

    $plugin = plugin_path("/$pluginName");
    $mark = '';

    $file = fopen("$plugin/ACTIVE", 'w');
    fwrite($file, $mark);
    fclose($file);
}

/**
 * Checks if a plugin is active
 */
function isPluginActive(string $pluginName): bool
{
    if (!pluginExists($pluginName)) {
        return false;
    }

    $plugin = plugin_path("/$pluginName");

    if (file_exists("$plugin/ACTIVE")) {
        return true;
    }

    return false;
}

/**
 * Unmarks a plugin as active
 */
function unmarkPluginActive(string $pluginName)
{
    if (!isPluginActive($pluginName)) {
        return;
    }

    $plugin = plugin_path("/$pluginName");

    unlink("$plugin/ACTIVE");
}

/**
 * Gets all active plugins
 */
function getActivePlugins()
{
    $plugins = getPlugins();
    $activePlugins = [];

    foreach ($plugins as $plugin) {
        if (isPluginActive($plugin)) {
            $activePlugins[] = $plugin;
        }
    }

    return $activePlugins;
}

/**
 * Gets all inactive plugins
 */
function getInactivePlugins()
{
    $plugins = getPlugins();
    $inactivePlugins = [];

    foreach ($plugins as $plugin) {
        if (!isPluginActive($plugin)) {
            $inactivePlugins[] = $plugin;
        }
    }

    return $inactivePlugins;
}

/**
 * Activates a plugin
 */
function activatePlugin(string $pluginName)
{
    markPluginActive($pluginName);

    loadActivePlugins();
}

/**
 * Deactivates a plugin
 */
function deactivatePlugin(string $pluginName)
{
    unmarkPluginActive($pluginName);

    loadActivePlugins();
}

/**
 * Loads all active plugins to memory
 */
function loadActivePlugins()
{
    $activePlugins = getActivePlugins();

    if (!empty($activePlugins)) {
        foreach ($activePlugins as $activePlugin) {
            require_once plugin_path("/$activePlugin/index.php");
        }
    }
}

/**
 * Loads all active plugins to memory
 */
function deletePlugin(string $pluginName)
{
    if (isPluginActive($pluginName)) {
        return false;
    }

    return deleteDir(plugin_path("/$pluginName"), true);
}

/**
 * Fetches available free plugins from repository
 */
function fetchPlugins()
{
    $url        = 'https://localhost:5000/api/v0';
    $content    = file_get_contents($url);
}
