<?php

$bundles = "";
$dest = "./assets/js/script.js";
$scripts = [
    "./src/js/nav.js",
    // "./src/js/footer.js",
];

foreach ($scripts as $script) {
    $bundle = file_get_contents($script);
    $bundles .= $bundle;
}

file_put_contents($dest, $bundles);

exec("uglifyjs $dest -o $dest");
