<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Ergnuor\ApiPlatform\EntityManager\RestEntityManagerInterface;
use Ergnuor\ApiPlatform\Persister\RestPersisterInterface;
use Ergnuor\ApiPlatform\ContextTrait;

class RestPersisterDataPersister implements ContextAwareDataPersisterInterface
{
    use ContextTrait;

    private RestEntityManagerInterface $restEntityManager;

    public function __construct(
        RestEntityManagerInterface $restEntityManager
    ) {
        $this->restEntityManager = $restEntityManager;
    }

    public function supports($data, array $context = []): bool
    {
        $resourceClass = $this->getResourceClassFromContext($context);

        $classNames = array_flip($this->restEntityManager->getClassMetadataFactory()->getAllClassNames());
        return isset($classNames[$resourceClass]);
    }

    private function getPersister(array $context): RestPersisterInterface
    {
        $resourceClass = $this->getResourceClassFromContext($context);
        return $this->restEntityManager->getPersisterForClass($resourceClass);
    }

    final public function persist($data, array $context = [])
    {
        return $this->getPersister($context)->persist($data);
//        $this->beforeOperation();
//
//        //todo может сделать вместо persist() create() и update()?
//
//        if (($context['collection_operation_name'] ?? null) == 'post') {
//            return $this->doCreate($data, $context);
//        }
//
//        if (($context['item_operation_name'] ?? null) == 'patch') {
//            return $this->doUpdate($data, $context);
//        }
//
//        throw new \RuntimeException('Unknown persistence operation');/
    }

    final public function remove($data, array $context = [])
    {
        return $this->getPersister($context)->remove($data);
    }
}