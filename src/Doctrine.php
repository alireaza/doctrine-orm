<?php

namespace AliReaza\Doctrine\ORM;

use Closure;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

/**
 * Class Doctrine
 *
 * @package AliReaza\Doctrine\ORM
 */
class Doctrine
{
    protected EntityManager $entityManager;
    protected ?SQLLogger $logger = null;

    /**
     * Doctrine constructor.
     *
     * @param array              $connection
     * @param array              $paths
     * @param Setup|Closure|null $config
     *
     * @throws ORMException
     */
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

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param SQLLogger|null $logger
     */
    public function enableQueryLog(?SQLLogger $logger = null): void
    {
        if (is_null($logger)) {
            $logger = new DebugStack();
        }

        $this->getEntityManager()->getConnection()->getConfiguration()->setSQLLogger($logger);

        $this->logger = $logger;
    }

    /**
     * @return SQLLogger|null
     */
    public function getQueryLog(): ?SQLLogger
    {
        return $this->logger;
    }
}
