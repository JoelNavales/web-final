<?php

declare(strict_types=1);

namespace App\Controllers;

use snap\Http\Request;
use snap\Http\Response;
use snap\View\Engine;

class HomeController
{
    public function __construct(
        private Engine $engine,
    ) {}

    public function index(Request $request): Response
    {
        return Response::view($this->engine->render('home', ['title' => 'Home']));
    }
}
