<?php
require '../vendor/autoload.php';
use App\Page;
use App\Structure;
use App\Validation\ValidateForm;
use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;

Dotenv::createImmutable(dirname(__DIR__))->load();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app');
define('CONTENT_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'site-content');
define('STRUCTURE_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'site-structure');
define('VIEWS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views');

$yaml_pattern = '/^.+\.yaml/i';

$app = AppFactory::create();
$app->addErrorMiddleware($_ENV['APP_DEBUG'], $_ENV['APP_DEBUG'], $_ENV['APP_DEBUG']);
session_start();

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(CONTENT_PATH));
$files = new RegexIterator($files, $yaml_pattern, RecursiveRegexIterator::GET_MATCH);
$structures = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(STRUCTURE_PATH));
$structures = new RegexIterator($structures, $yaml_pattern, RecursiveRegexIterator::GET_MATCH);

$commonElements = [];
foreach ($structures as $element) {
    $element = $element[0];
    $structureElement = new Structure($element);
    if(!is_null($structureElement->menus)) {
        $commonElements['menus'] = $structureElement->menus;
    }
    if(!is_null($structureElement->blocs)) {
        $commonElements['blocs'] = $structureElement->blocs;
    }
}

foreach ($files as $file) {
    $file = $file[0];
    $page = new Page($file);

;    $app->any($page->getUrl(), function (Request $request, Response $response, $args) use ($page, $commonElements, $app) {
        require APP_PATH . DIRECTORY_SEPARATOR . 'Utils' . DIRECTORY_SEPARATOR .'helpers.php';

        if($request->getMethod() === 'POST' && $request->getUri()->getPath() === '/contact') {
            $postedData = $request->getParsedBody();
            $inputs = new ValidateForm($postedData, $request->getUri()->getPath());
            $errors = $inputs->validate();
            $result['values'] = $inputs;
            $result['errors'] = $errors;
            $flash = new Messages();
            if(!is_null($flash->getMessage('success'))) {
                $result = null;
                $result['success'] = $flash->getMessage('success');
            }
            $response->getBody()->write($page->render($commonElements, $result));
        } else {
            $response->getBody()->write($page->render($commonElements));
        }
        return $response;
    });
}
$app->run();