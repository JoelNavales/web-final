<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use snap\Application;
use snap\Container\Container;
use snap\database\Connection;
use snap\database\MySQLDriver;
use snap\database\SQLiteDriver;
use snap\Http\Request;
use snap\Http\Router;
use snap\View\Engine;
use Doctrine\ORM\EntityManagerInterface;

$dbConfig  = require __DIR__ . '/../config/database.php';
$appConfig = require __DIR__ . '/../config/app.php';

$container = new Container();

$container->singleton(
    EntityManagerInterface::class,
    function () use ($dbConfig) {
        $connName = $dbConfig['default'];
        $connConf = $dbConfig['connections'][$connName];
        $driver   = $connName === 'sqlite' ? new SQLiteDriver() : new MySQLDriver();
        return (new Connection($driver, $connConf))->getEntityManager();
    },
);

$container->singleton(
    Engine::class,
    fn() => new Engine(__DIR__ . '/../app/Views'),
);

$container->bind(
    TaskRepositoryInterface::class,
    fn(Container $c) => $c->resolve(EntityManagerInterface::class)->getRepository(Task::class),
);

$router  = new Router();
$request = new Request();

(require __DIR__ . '/../routes/web.php')($router);

(new Application($container, $router, $request))->run();
