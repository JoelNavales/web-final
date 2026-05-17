<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;
use core\Application;
use core\Container\Container;
use core\database\Connection;
use core\database\MySQLDriver;
use core\database\SQLiteDriver;
use core\Http\Request;
use core\Http\Router;
use core\View\Engine;

$dbConfig  = require __DIR__ . '/../config/database.php';
$appConfig = require __DIR__ . '/../config/app.php';

$container = new Container();

$container->singleton(
    PDO::class,
    function () use ($dbConfig) {
        $connName = $dbConfig['default'];
        $connConf = $dbConfig['connections'][$connName];
        $driver   = $connName === 'sqlite' ? new SQLiteDriver() : new MySQLDriver();

        return (new Connection($driver, $connConf))->getPdo();
    },
);

$container->singleton(
    Engine::class,
    fn() => new Engine(__DIR__ . '/../app/Views'),
);

$container->bind(
    TaskRepositoryInterface::class,
    fn(Container $c) => new TaskRepository($c->resolve(PDO::class)),
);

$router  = new Router();
$request = new Request();

(require __DIR__ . '/../routes/web.php')($router);

(new Application($container, $router, $request))->run();
