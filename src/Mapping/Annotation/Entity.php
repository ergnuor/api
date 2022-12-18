<?php

declare(strict_types=1);

namespace Ergnuor\Api\Mapping\Annotation;

use Attribute;
use Ergnuor\Mapping\Annotation\AnnotationInterface;

/**
 * @Annotation
 * @NamedArgumentConstructor()
 * @Target({"CLASS"})
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Entity implements AnnotationInterface
{
    public string $repositoryClass;

    public ?string $persisterClass = null;

    public function __construct(string $repositoryClass, ?string $persisterClass = null)
    {
        $this->repositoryClass = $repositoryClass;
        $this->persisterClass = $persisterClass;
    }
}