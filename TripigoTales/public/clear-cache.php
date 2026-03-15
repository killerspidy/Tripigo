<?php

// base path set karo
$basePath = dirname(__DIR__);

// folders create if missing
$paths = [
    $basePath . '/storage/framework/sessions',
    $basePath . '/storage/framework/cache',
    $basePath . '/storage/framework/views',
    $basePath . '/bootstrap/cache',
];

foreach ($paths as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0775, true);
        echo "Created: $path <br>";
    }
}

// delete cache files
function deleteFiles($dir) {
    if (!is_dir($dir)) return;
    foreach (scandir($dir) as $file) {
        if ($file != '.' && $file != '..') {
            $full = $dir . '/' . $file;
            if (is_dir($full)) {
                deleteFiles($full);
            } else {
                unlink($full);
            }
        }
    }
}

deleteFiles($basePath . '/storage/framework/cache');
deleteFiles($basePath . '/storage/framework/views');
deleteFiles($basePath . '/bootstrap/cache');

echo "<br><b>Laravel cache cleared successfully ✅</b>";
