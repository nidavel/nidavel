<?php

use App\Models\Post;

/*
| This is a group of functions that should be used by third party devs
| to trigger a function on any of the publish events
*/

function runOnPostPublish(string|array|callable $function = null)
{
    static $functions;

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

    return $functions;
}

function runFunctionsPostPublished(Post $post)
{
    $functions = runOnPostPublish();
    
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
