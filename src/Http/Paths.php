<?php

namespace App\Http;

class Paths
{

    public function readAndOutputRequestedUrl(): string
    {
        $requestedUrl = $_SERVER['REQUEST_URI'];
        $requestedPath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        return str_replace($requestedPath, '', $requestedUrl);
    }

    public function readAndOutputRequestedPath(): string
    {
        $requestedUrl = $_SERVER['REQUEST_URI'];
        return str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    }

    public function getRequestType(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

}