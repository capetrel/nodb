<?php

    function asset(string $path) {
        global $app;
        return $app->request->getRootUri() . '/' . trim($path, '/');
    }

    function getEnvValue($key) {
        return $_ENV[$key];
    }

