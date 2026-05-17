<?php

declare(strict_types=1);

namespace App\Middleware;

use core\Http\Middleware;
use core\Http\Request;
use core\Http\Response;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): Response
    {
        if (empty($_SESSION['user'])) {
            return Response::redirect('/login');
        }

        return $next($request);
    }
}
