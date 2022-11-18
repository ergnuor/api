<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Mapping;


use Ergnuor\Mapping\AbstractClassMetadataFactoryAdapter;
use Ergnuor\ApiPlatform\Mapping\Annotation;

class ClassMetadataFactoryAdapter extends AbstractClassMetadataFactoryAdapter
{
    public function isCorrectCachedInstance($cachedMetadata): bool
    {
        return $cachedMetadata instanceof ClassMetadata;
    }

    /**
     * @param ClassMetadata $cachedMetadata
     * @return void
     */
    public function afterGotFromCache($cachedMetadata): void
    {
    }

    public function loadMetadata(string $className)
    {
        $classNameReflection = new \ReflectionClass($className);

        $classAnnotations = $this->reader->getClassAnnotations($classNameReflection);

        if (!isset($classAnnotations[Annotation\Entity::class])) {
            throw new \RuntimeException(
                sprintf(
                    "Entity '$className' should be marked as '%s'",
                    Annotation\Entity::class
                )
            );
        }

        $classMetadata = new ClassMetadata($className);

        $entityAnnotation = $classAnnotations[Annotation\Entity::class];
        assert($entityAnnotation instanceof Annotation\Entity);

        $classMetadata->setRepositoryClass($entityAnnotation->repositoryClass);

        if (!empty($entityAnnotation->persisterClass)) {
            $classMetadata->setPersisterClass($entityAnnotation->persisterClass);
        }

        return $classMetadata;
    }

    /**
     * @param ClassMetadata $cachedMetadata
     * @return void
     */
    public function afterMetadataLoaded($cachedMetadata): void
    {
    }

    protected function isTransient(string $className): bool
    {
        $classAnnotations = $this->reader->getClassAnnotations(new \ReflectionClass($className));

        return !isset($classAnnotations[Annotation\Entity::class]);
    }
}