<?php

declare(strict_types=1);

namespace snap;

use snap\Container\Container;
use snap\Http\Request;
use snap\Http\Response;
use snap\Http\Router;

class Application
{
    public function __construct(
        private Container $container,
        private Router    $router,
        private Request   $request,
    ) {}

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

        $controller = $this->container->resolve($controllerClass);
        $response   = $controller->$method($request);

        if ($response instanceof Response) {
            $response->send();
        }
    }
}
