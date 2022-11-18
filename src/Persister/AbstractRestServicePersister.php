<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Persister;

use Ergnuor\ApiPlatform\RegistryInterface;

abstract class AbstractRestServicePersister extends AbstractRestPersister
{
    public function __construct(
        RegistryInterface $registry
    ) {
        parent::__construct(
            $registry->getEntityManager(),
            $registry->getValidator()
        );
    }
}