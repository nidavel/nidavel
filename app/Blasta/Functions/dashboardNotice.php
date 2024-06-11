<?php

/**
 * Adds a notice to the session
 */
function addDashboardNotice(string $id, array $details)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['dashboard-notices'][toSnakeCase(' ', $id)] = $details;
}

/**
 * Removes a notice from session
 */
function removeDashboardNotice(string $id)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $id = toSnakeCase('_', $id);
    unset($_SESSION['dashboard-notices'][$id]);
}

/**
 * Emits an alert to the cookie
 */
function emitDashboardAlert(string $title, string $message, string $type)
{
    $alert = '';
    $values = "$title|$message|$type";
    setcookie('dashboard-alerts', $values, timestamp() + 86500);
    $_COOKIE['dashboard-alerts'] = $values;
}
