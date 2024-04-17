<?php

/**
 * Embeds script to the html
 */
function embedScript(string $resource, string $location = 'head', array $attributes = [])
{
    $script = '<script';
    foreach ($attributes as $attribute => $value) {
        $script .= ' ' . $attribute . '="'. $value . '"';
    }
    $script .= ">\n";

    $script .= file_get_contents($resource) . "\n";

    $script .= '</script>';

    switch ($location) {
        case 'head':
            appendToPostHead($script);
            break;
        case 'body':
            appendToBody($script);
            break;
        default:
            exit('Unknown location for embed script');
    }
}

/**
 * Attaches script from online source to the html
 */
function sourceScript(string $resource, string $location = 'body', array $attributes = [])
{
    $script = '<script src="' . $resource . '"';
    foreach ($attributes as $attribute => $value) {
        $script .= ' ' . $attribute . '="'. $value . '"';
    }
    $script .= "></script>\n";

    switch ($location) {
        case 'head':
            appendToPostHead($script);
            break;
        case 'body':
            appendToBody($script);
            break;
        default:
            exit('Unknown location for embed script');
    }
}