<?php

declare(strict_types=1);

namespace core;

use core\Container\Container;
use core\Http\Middleware;
use core\Http\Pipeline;
use core\Http\Request;
use core\Http\Response;
use core\Http\Router;

class Application
{
    private Pipeline $pipeline;

    public function __construct(
        private Container $container,
        private Router    $router,
        private Request   $request,
    ) {
        $this->pipeline = new Pipeline();
    }

    public function pipe(Middleware $middleware): static
    {
        $this->pipeline->pipe($middleware);
        return $this;
    }

    public function run(): void
    {
        $match = $this->router->resolve($this->request);

        if (empty($match)) {
            http_response_code(404);
            echo '<h1>404 Not Found</h1><p>The requested page does not exist.</p>';
            return;
        }

        [$controllerClass, $method] = $match['handler'];
        $params  = $match['params'];
        $request = $this->request->withParams($params);

        $response = $this->pipeline->run(
            $request,
            function (Request $req) use ($controllerClass, $method): Response {
                $controller = $this->container->resolve($controllerClass);
                return $controller->$method($req);
            },
        );

        if ($response instanceof Response) {
            $response->send();
        }
    }
}
