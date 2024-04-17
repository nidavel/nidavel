<?php

function blastaGlobalFunctions()
{
    $dir = new DirectoryIterator(dirname(__FILE__));
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot() && $fileinfo->getFilename() != 'blastaGlobalFunctions.php') {
            // var_dump($fileinfo->getFilename());
            require_once($fileinfo->getFilename());
        }
    }
}

blastaGlobalFunctions();
loadActivePlugins();
loadActiveThemeIndex();
