<?php

/**
 * Compiles all the functions in app/Blasta/Functions into one file
 */
function compileFuncs()
{
    $ignore = [
        'blastaGlobalFunctions.php',
        'index.php',
        'compileFuncs.php',
        'publishEventExport.php',
        'home.php',
        'categories.php',
        'settings.php',
    ];

    $fp = fopen(base_path('app/Blasta/Functions/index.php'), 'w');
    fwrite($fp, "<?php\n");
    fclose($fp);

    $dir = new DirectoryIterator(dirname(__FILE__));
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDot() || in_array($fileinfo->getFilename(), $ignore)) {
            continue;
        }

        $content = file_get_contents($fileinfo->getPathName());
        $content = str_replace("<?php\n", '', $content);
        $content = str_replace('    ', ' ', $content);
        $content = preg_replace('/(\/\/ .*\n)/', '', $content);
        $content = str_replace("\n", ' ', $content);
        // $content = preg_replace('/\/\*.*\*\/ /', '', $content);
        $fp = fopen(base_path('app/Blasta/Functions/index.php'), 'a');
        fwrite($fp, $content);
        fclose($fp);
    }

    $content = file_get_contents(base_path('app/Blasta/Functions/index.php'));
    $fp = fopen(base_path('app/Blasta/Functions/index.php'), 'w');
    fwrite($fp, str_replace(' <?php', '', $content));
    fclose($fp);
}
