<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.url');
    }
}
