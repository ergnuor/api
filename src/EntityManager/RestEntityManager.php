<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\EntityManager;

use Ergnuor\Mapping\ClassMetadataFactoryInterface;
use Ergnuor\ApiPlatform\Mapping\ClassMetadataInterface;
use Ergnuor\ApiPlatform\Persister\RestPersisterInterface;
use Ergnuor\ApiPlatform\Repository\RestRepositoryInterface;
use Psr\Container\ContainerInterface;

class RestEntityManager implements RestEntityManagerInterface
{
    private ClassMetadataFactoryInterface $classMetadataFactory;
    private ContainerInterface $restRepositoryServiceLocator;
    private ContainerInterface $restPersisterServiceLocator;

    public function __construct(
        ClassMetadataFactoryInterface $classMetadataFactory,
        ContainerInterface $restRepositoryServiceLocator,
        ContainerInterface $restPersisterServiceLocator
    ) {
        $this->classMetadataFactory = $classMetadataFactory;
        $this->restRepositoryServiceLocator = $restRepositoryServiceLocator;
        $this->restPersisterServiceLocator = $restPersisterServiceLocator;
    }

    /** @return ClassMetadataFactoryInterface<ClassMetadataInterface> */
    public function getClassMetadataFactory(): ClassMetadataFactoryInterface
    {
        return $this->classMetadataFactory;
    }

    public function getClassMetadataFor(string $className): ClassMetadataInterface
    {
        return $this->classMetadataFactory->getMetadataFor($className);
    }

    public function getRepositoryForClass(string $className): RestRepositoryInterface
    {
        $classMetadata = $this->getClassMetadataFor($className);
        return $this->restRepositoryServiceLocator->get($classMetadata->getRepositoryClass());
    }

    public function getPersisterForClass(string $className): RestPersisterInterface
    {
        $classMetadata = $this->getClassMetadataFor($className);
        return $this->restPersisterServiceLocator->get($classMetadata->getPersisterClass());
    }
}