<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\EntityManager;

use Ergnuor\Mapping\ClassMetadataFactoryInterface;
use Ergnuor\ApiPlatform\Mapping\ClassMetadataInterface;
use Ergnuor\ApiPlatform\Persister\RestPersisterInterface;
use Ergnuor\ApiPlatform\Repository\RestRepositoryInterface;

interface RestEntityManagerInterface
{
    /** @return ClassMetadataFactoryInterface<ClassMetadataInterface> */
    public function getClassMetadataFactory(): ClassMetadataFactoryInterface;

    public function getClassMetadataFor(string $className): ClassMetadataInterface;

    public function getRepositoryForClass(string $className): RestRepositoryInterface;

    public function getPersisterForClass(string $className): RestPersisterInterface;
}