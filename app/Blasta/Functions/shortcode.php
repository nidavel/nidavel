<?php

/**
 * This function replaces a string shortcode with a functionality
 */
function shortcode(string $post)
{
    $codes = getShortcodes();

    if (!isset($codes)) {
        return $post;
    }

    foreach ($codes as $code) {
        $script = '<script type="text/javascript">';
        $script .= file_get_contents($code['resource']);
        $script .= '</script>';
        $post = str_replace('['.$code['shortcode'].']', $code['replacement'].$script, $post);
    }

    return $post;
}

/**
 * This function registers a shortcode to the application
 */
function registerShortcode(
    string $shortcode   = null,
    string $resource    = null,
    string $description = null,
    string $author      = null,
    string $replacement = ''
    )
{
    static $codes;

    if (func_num_args() < 1) {
        return $codes;
    }

    if ($codes != null) {
        foreach ($codes as $code) {
            if ($code['shortcode'] == $shortcode) {
                throw new \Exception("Shortcode $shortcode already exist.");
            }
        }
    }

    $codes[] = [
        'shortcode'     => $shortcode,
        'resource'      => $resource,
        'description'   => $description,
        'author'        => $author,
        'replacement'   => $replacement
    ];
}

/**
 * This function lists all available shortcodes
 */
function getShortcodes()
{
    return registerShortcode();
}

// registerShortcode(
//     'NLRTMDJS',
//     public_path('js/alertme.js'),
//     'This shortcode alerts my name to the browser',
//     'Ikenna',
//     'Ikenna'
// );
