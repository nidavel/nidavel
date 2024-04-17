<?php

function exportAssets()
{
    if (file_exists(front_path('/assets.json'))) {
        $assets = file_get_contents(front_path('/assets.json'));
        $assets = json_decode($assets)->assets;
    } else {
        return;
    }

    if (file_exists(public_path('/my_exports/assets'))) {
        rrmdir(public_path('/my_exports/assets'));
    }

    foreach ($assets as $asset) {
        $dirs = explode('/', $asset);
        $numDirs = count($dirs);
        if ($numDirs > 1) {
            array_pop($dirs);
            $dirs = implode('/', $dirs);

            if (!is_dir(public_path("/my_exports/$dirs"))) {
                mkdir(public_path("/my_exports/$dirs"), 0777, true);
            }
        }
        copy(front_path("/$asset"), public_path("/my_exports/$asset"));
    }
}
