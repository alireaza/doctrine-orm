<?php

namespace AliReaza\Doctrine\ORM;

use Closure;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{
    protected EntityManager $entityManager;
    protected ?SQLLogger $logger = null;

    public function __construct(array $connection, array $paths, Setup|Closure $config = null)
    {
        if (!$config instanceof Setup) {
            $__config = $config;

            $config = Setup::createConfiguration();

            $driver = new AttributeDriver($paths);
            $config->setMetadataDriverImpl($driver);

            if ($__config instanceof Closure) {
                $config = $__config($config);
            }
        }

        $this->entityManager = EntityManager::create($connection, $config);
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function enableQueryLog(?SQLLogger $logger = null): void
    {
        if (is_null($logger)) {
            $logger = new DebugStack();
        }

        $this->getEntityManager()->getConnection()->getConfiguration()->setSQLLogger($logger);

        $this->logger = $logger;
    }

    public function getQueryLog(): ?SQLLogger
    {
        return $this->logger;
    }
}
