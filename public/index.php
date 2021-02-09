<?php

use Slim\Slim;

require '../vendor/autoload.php';

define('CONTENT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'content');

$app = new Slim(['debug' => true]);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(CONTENT_PATH));
$files = new RegexIterator($files, '/^.+\.yaml/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $file = $file[0];
    $path = str_replace(CONTENT_PATH, '', $file);
    $path = str_replace('.yaml', '', $path);
    $path = str_replace('index', '', $path);
    $app->any($path, function(){
        echo "salut";
    });
}

$app->run();