<?php

function asset(string $path) {
    global $app;
    return $app->getBasePath() . '/' . trim($path, '/');
}

function getEnvValue($key) {
    return $_ENV[$key];
}

function setActiveItem( string $link) {
    $requestUriParts = explode('?', $_SERVER['REQUEST_URI']);
    $requestUri = $requestUriParts[0];
    if($requestUri === $link){
        return 'active';
    }
    $uriParts = explode('/', $requestUri);
    if (str_contains($link, $uriParts[1]) && !empty($uriParts[1])) {
        return 'active';
    }
    return '';
}