<?php

function blastaGlobalClasses()
{
    $dir = new DirectoryIterator(dirname(__FILE__));
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot() && $fileinfo->getFilename() != 'blastaGlobalClasses.php') {
            require_once($fileinfo->getFilename());
        }
    }
}

blastaGlobalClasses();
