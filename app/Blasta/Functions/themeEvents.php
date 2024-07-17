<?php

/**
 * Runs functions on theme activate event
 */
function runOnThemeActivate(string|array|callable $function = null)
{
    static $functions;

    compileThemeEventFunctions($function, $functions);

    return $functions;
}

/**
 * Runs functions on theme deactivate event
 */
function runOnThemeDeactivate(string|array|callable $function = null)
{
    static $functions;

    compileThemeEventFunctions($function, $functions);

    return $functions;
}

/**
 * Runs functions on theme delete event
 */
function runOnThemeDelete(string|array|callable $function = null)
{
    static $functions;

    compileThemeEventFunctions($function, $functions);

    return $functions;
}

/**
 * Compiles the functions to run for each theme event
 */
function compileThemeEventFunctions(string|array|callable $function = null, &$functions)
{
    if (!is_null($function)) {
        if (is_string($function)) {
            $functions[] = $function;
        }

        if (is_array($function)) {
            foreach ($function as $func) {
                $functions[] = $func;
            }
        }
    }
}

/**
 * Assigns function for respective theme event
 */
function runFunctionsOnThemeEvent(string $event)
{
    $functions;

    switch ($event) {
        case 'theme-activate':
            $functions = runOnThemeActivate();
            break;
        case 'theme-deactivate':
            $functions = runOnThemeDeactivate();
            break;
        case 'theme-delete':
            $functions = runOnThemeDelete();
            break;
        default:
            $functions = runOnThemeActivate();
    }
    
    runThemeEventFunctions($functions);
}

/**
 * Runs the function names given as string
 */
function runThemeEventFunctions(array $functions)
{
    if (!empty($functions)) {
        foreach ($functions as $function) {
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
