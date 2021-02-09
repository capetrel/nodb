<?php
require '../vendor/autoload.php';

use App\Page;
use Slim\Slim;

define('CONTENT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'content');
define('VIEWS_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ressources' . 'views');
define('LAYOUTS_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ressources' . DIRECTORY_SEPARATOR.  'views' . DIRECTORY_SEPARATOR . 'layouts');

$app = new Slim(['debug' => true]);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(CONTENT_PATH));
$files = new RegexIterator($files, '/^.+\.yaml/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $file = $file[0];
    $page = new Page($file);
    $app->any($page->getUrl(), function() use ($page){
        $page->render();
    });
}

$app->run();