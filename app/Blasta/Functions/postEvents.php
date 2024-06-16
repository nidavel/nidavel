<?php

use App\Models\Post;

/*
| This is a group of functions that should be used by third party devs
| to trigger a function on any of the publish events
*/

/**
 * Runs functions on post publish event
 */
function runOnPostPublish(string|array|callable $function = null)
{
    static $functions;

    compileFunctions($function, $functions);

    return $functions;
}

/**
 * Runs functions on post publish event
 */
function runOnPostDelete(string|array|callable $function = null)
{
    static $functions;

    compileFunctions($function, $functions);

    return $functions;
}

/**
 * Assigns function for respective post event
 */
function runFunctionsOnPostEvent(string $event, Post $post)
{
    $functions;

    switch ($event) {
        case 'post-publish':
            $functions = runOnPostPublish();
            break;
        case 'post-delete':
            $functions = runOnPostDelete();
            break;
        default:
            $functions = runOnPostPublish();
    }
    
    runFunctions($functions, $post);
}

/**
 * Compiles the functions to run for each post event
 */
function compileFunctions(string|array|callable $function = null, &$functions)
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
 * Runs the function names given as string
 */
function runFunctions(array $functions, Post $post)
{
    if (!empty($functions)) {
        foreach ($functions as $function) {
            if (is_string($function)) {
                if (function_exists($function)) {
                    $fct = new ReflectionFunction($function);
                    $params = $fct->getNumberOfRequiredParameters();
                    
                    if ($params === 1) {
                        $function($post);
                    }
                    else if ($params === 0) {
                        $function();
                    }
                } else {
                    throw new Exception("Function $function does not exist", 1);
                }
            }
        }
    }
}
