<?php
require '../vendor/autoload.php';
use App\Page;
use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;

Dotenv::createImmutable(dirname(__DIR__))->load();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app');
define('CONTENT_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'content');
define('VIEWS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');

$app = AppFactory::create(); // Slim 4
session_start();
$container = $app->getContainer();
$container['flash'] = function () {
    return new Messages();
};

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(CONTENT_PATH));
$files = new RegexIterator($files, '/^.+\.yaml/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $file = $file[0];
    $page = new Page($file);
    $app->any($page->getUrl(), function (Request $request, Response $response, $args) use ($page, $app) {
        require APP_PATH . DIRECTORY_SEPARATOR . 'helpers.php';

        if($request->getMethod() === 'POST' && $request->getUri()->getPath() === '/contact') {
            $postedData = $request->getParsedBody();
            $inputs = new \App\ValidateForm($postedData, $request->getUri()->getPath());
            $errors = $inputs->validate();
            $result['values'] = $inputs;
            $result['errors'] = $errors;
            $flash = new Messages();
            if(!is_null($flash->getMessage('success'))) {
                $result = null;
                $result['success'] = $flash->getMessage('success');
            }
            $response->getBody()->write($page->render($result));
        } else {
            $response->getBody()->write($page->render());
        }
        return $response;
    });
}

$app->run();