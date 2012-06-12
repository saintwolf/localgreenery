<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(__DIR__ . DS . 'lib' . DS . 'functions.php');
$uploadDir = __DIR__ . DS . 'uploads';
$dir = opendir($uploadDir);
//$pics=dirname();
while ($pic = readdir($dir)) {
    $pics[] = $pic;
}
if ($pics[0] != '') {
    foreach ($pics as $p) {

        if ($p != '' && $p != '.' && $p != '..' && $p != 'thumbs') {
            if (!file_exists($uploadDir . DS . 'thumbs' . DS . 'tn_' . $p)) {
                echo "Create thumb for " . $uploadDir . DS . $p . " in "
                        . $uploadDir . DS . 'thumbs' . DS . 'tn_' . $p . "\n";
                createthumb($uploadDir . DS . $p,
                        $uploadDir . DS . 'thumbs' . DS . 'tn_' . $p, 100, 100);
            } else {
                echo "Skipping: Thumbnail already generated: " . $uploadDir
                        . DS . 'thumbs' . DS . 'tn_' . $p . "\n";
            }
        } else {
            echo "Skipping: Directory: " . $uploadDir . DS . $p
                    . "\n";
        }

    }
    echo 'Thumbs have been created!';
}
