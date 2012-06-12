<?php
define('DS', DIRECTORY_SEPARATOR);
require_once(__DIR__ . DS . 'lib' . DS . 'functions.php');
$uploadDir = __DIR__ . DS . 'uploads';
// Check if the upload and thumbs directory exist
if (!file_exists($uploadDir)) {
    echo 'Creating upload directory at: ' . $uploadDir . "\n";
    mkdir($uploadDir, 0755) or die('Fatal: Unable to create directory: ' . $uploadDir . "\n");
}
if (!file_exists($uploadDir . DS . 'thumbs')) {
    echo 'Creating thumbs directory at: ' . $uploadDir . DS . 'thumbs' . "\n";
    mkdir($uploadDir . DS . 'thumbs', 0755) or die('Fatal: Unable to create directory: ' . $uploadDir . "\n");
}
$dir = opendir($uploadDir);
//$pics=dirname();
while ($pic = readdir($dir)) {
    $pics[] = $pic;
}
if ($pics[0] != '') {
    foreach ($pics as $p) {

        if (!is_dir($uploadDir . DS . $p)) {
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
