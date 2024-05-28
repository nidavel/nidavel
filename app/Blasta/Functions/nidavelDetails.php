<?php

function getVersion()
{
    $details = file_get_contents(base_path('app/Blasta/details.json'));
    $details = json_decode($details);
    $version = $details->version;
    return $version;
}
