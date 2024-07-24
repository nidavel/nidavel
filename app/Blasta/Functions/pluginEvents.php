<?php

/**
 * Runs functions on plugin activate event
 */
function runOnPluginActivate(string|array|callable $function = null, string $pluginName = null)
{
    static $functions;

    if (!is_null($function)) {
        compilePluginEventFunctions($function, $functions, $pluginName);
    }

    return $functions;
}

/**
 * Runs functions on Plugin deactivate event
 */
function runOnPluginDeactivate(string|array|callable $function = null, string $pluginName = null)
{
    static $functions;

    if (!is_null($function)) {
        compilePluginEventFunctions($function, $functions, $pluginName);
    }

    return $functions;
}

/**
 * Runs functions on Plugin delete event
 */
function runOnPluginDelete(string|array|callable $function = null, string $pluginName = null)
{
    static $functions;

    if (!is_null($function)) {
        compilePluginEventFunctions($function, $functions, $pluginName);
    }

    return $functions;
}

/**
 * Compiles the functions to run for each plugin event
 */
function compilePluginEventFunctions(string|array|callable $function = null, &$functions, string $pluginName)
{
    if (!is_null($function)) {
        if (is_string($function)) {
            $functions[$pluginName][] = $function;
        }

        if (is_array($function)) {
            foreach ($function as $func) {
                $functions[$pluginName][] = $func;
            }
        }
    }
}

/**
 * Assigns function for respective plugin event
 */
function runFunctionsOnPluginEvent(string $event, string $pluginName)
{
    $functions;

    switch ($event) {
        case 'plugin-activate':
            $functions = runOnPluginActivate();
            break;
        case 'plugin-deactivate':
            $functions = runOnPluginDeactivate();
            break;
        case 'plugin-delete':
            $functions = runOnPluginDelete();
            break;
        default:
            $functions = runOnPluginActivate();
    }
    
    runPluginEventFunctions($functions, $pluginName);
}

/**
 * Runs the function names given as string
 */
function runPluginEventFunctions(array|null $functions = null, string|null $pluginName = null)
{
    if (!empty($functions[$pluginName])) {
        foreach ($functions[$pluginName] as $function) {
            if (is_string($function)) {
                if (function_exists($function)) {
                    $function();
                } else {
                    throw new Exception("Function $function does not exist", 1);
                }
            }
        }
    }
}
