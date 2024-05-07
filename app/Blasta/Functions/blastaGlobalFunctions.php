<?php

function blastaGlobalFunctions()
{
    if (!file_exists(base_path('app/Blasta/Functions/index.php'))) {
        $dir = new DirectoryIterator(dirname(__FILE__));
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot() 
                && $fileinfo->getFilename() != 'blastaGlobalFunctions.php') {
                require_once($fileinfo->getFilename());
            }
        }
    } else {
        require_once base_path('app/Blasta/Functions/index.php');
        require_once base_path('app/Blasta/Functions/home.php');
        require_once base_path('app/Blasta/Functions/publishEventExport.php');
    }
}

blastaGlobalFunctions();
loadActivePlugins();
loadActiveThemeIndex();
