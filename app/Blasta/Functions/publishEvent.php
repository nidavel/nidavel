<?php

/*
| This is a group of functions that should be used by third party devs
| to trigger a function on any of the publish events
*/

function runOnPostPublish(string|array $function = null)
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

function runFunctionsPostPublished()
{
    $functions = runOnPostPublish();
    
    if (!empty($functions)) {
        foreach ($functions as $function) {
            if (function_exists($function)) {
                $function();
            } else {
                throw new Exception("FUnction $function does not exist", 1);
            }
        }
    }
}
