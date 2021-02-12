<?php

use App\FormBuilder;

function asset(string $path) {
    global $app;
    return $app->getBasePath() . '/' . trim($path, '/');
}

function getEnvValue($key) {
    return $_ENV[$key];
}

