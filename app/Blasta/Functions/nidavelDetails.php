<?php

/**
 * Returns Nidavel version
 */
function getVersion()
{
    $details = file_get_contents(base_path('app/Blasta/details.json'));
    $details = json_decode($details);
    $version = $details->version;
    return $version;
}

/**
 * Returns list of contributors
 */
function getContributors(bool $toString = true)
{
    $details = file_get_contents(base_path('app/Blasta/details.json'));
    $details = json_decode($details);
    $contributors = $details->contributors;

    if ($toString === true) {
        $contributors = \implode(', ', $contributors);
    }
    
    return $contributors;
}
