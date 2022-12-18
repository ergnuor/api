<?php
declare(strict_types=1);

namespace Ergnuor\Api\EntityManager;

use Ergnuor\Mapping\ClassMetadataFactoryInterface;
use Ergnuor\Api\Mapping\ClassMetadataInterface;
use Ergnuor\Api\Persister\RestPersisterInterface;
use Ergnuor\Api\Repository\RestRepositoryInterface;

interface RestEntityManagerInterface
{
    /** @return ClassMetadataFactoryInterface<ClassMetadataInterface> */
    public function getClassMetadataFactory(): ClassMetadataFactoryInterface;

    public function getClassMetadataFor(string $className): ClassMetadataInterface;

    public function getRepositoryForClass(string $className): RestRepositoryInterface;

    public function getPersisterForClass(string $className): RestPersisterInterface;
}