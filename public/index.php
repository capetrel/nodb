<?php
require '../vendor/autoload.php';
use App\Page;
use Dotenv\Dotenv;
use Slim\Slim;

Dotenv::createImmutable(dirname(__DIR__))->load();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app');
define('CONTENT_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'content');
define('VIEWS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');

$app = new Slim(['debug' => $_ENV['APP_DEBUG']]);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(CONTENT_PATH));
$files = new RegexIterator($files, '/^.+\.yaml/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $file = $file[0];
    $page = new Page($file);
    $app->any($page->getUrl(), function() use ($page, $app){
        require APP_PATH . DIRECTORY_SEPARATOR . 'helpers.php';
        echo $page->render();
    });
}

$app->run();