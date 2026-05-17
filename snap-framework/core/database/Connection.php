<?php

declare(strict_types=1);

namespace core\database;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;

class Connection
{
    private EntityManagerInterface $entityManager;

    public function __construct(DatabaseDriver $driver, array $config)
    {
        $ormConfig = ORMSetup::createAttributeMetadataConfig(
            paths: [$config['models_path']],
            isDevMode: true,
        );

        // PHP 8.4+ uses native lazy objects; no proxy directory is needed.
        $ormConfig->enableNativeLazyObjects(true);

        $connectionParams = $driver->getConnectionParams($config);
        $dbalConnection   = DriverManager::getConnection($connectionParams);

        $this->entityManager = new EntityManager($dbalConnection, $ormConfig);
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
