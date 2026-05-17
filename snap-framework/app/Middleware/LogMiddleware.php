<?php

declare(strict_types=1);

namespace App\Middleware;

use core\Http\Middleware;
use core\Http\Request;
use core\Http\Response;

class LogMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): Response
    {
        $start = microtime(true);

        /** @var Response $response */
        $response = $next($request);

        $duration = round((microtime(true) - $start) * 1000, 2);
        error_log("[{$request->method}] {$request->path} — {$duration}ms");

        return $response;
    }
}
