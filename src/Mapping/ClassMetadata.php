<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Mapping;

class ClassMetadata implements ClassMetadataInterface
{
    private string $className;
    private string $repositoryClass;
    private string $persisterClass;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getRepositoryClass(): string
    {
        return $this->repositoryClass;
    }

    public function getPersisterClass(): string
    {
        return $this->persisterClass;
    }

    public function setRepositoryClass(string $repositoryClass): ClassMetadata
    {
        $this->repositoryClass = $repositoryClass;
        return $this;
    }

    public function setPersisterClass(string $persisterClass): ClassMetadata
    {
        $this->persisterClass = $persisterClass;
        return $this;
    }


}