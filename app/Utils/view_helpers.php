<?php

function asset(string $path) {
    global $app;
    $root = getEnvValue('DOC_ROOT');
    return $app->getBasePath() . $root . trim($path, '/');
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

function filterContentByTag(array $contents, string $tag, string $key = 'tag'): array {
    return array_filter($contents, function($item) use ($key, $tag) {
        if(isset($item[$key][$tag])) {
            return $item;
        }
        return null;
    });
}

function setTagsForInput(array $contents, string $tag): array {
    $categories = [];
    foreach($contents as $item) {
        foreach ($item[$tag] as $key => $name) {
            if(!in_array($key, $item[$tag])) {
                $categories[$key] = $name;
            }
        }
    }
    return $categories;
}