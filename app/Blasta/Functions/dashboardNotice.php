<?php

/**
 * Adds a notice to the session
 */
function addNotice(string $id, array $details)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['dashboard-notices'][toSnakeCase(' ', $id)] = $details;
}

/**
 * Removes a notice from session
 */
function removeNotice(string $name)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $name = toSnakeCase('_', $name);
    unset($_SESSION['dashboard-notices'][$name]);
}
