<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Repository;

use Ergnuor\ApiPlatform\RegistryInterface;

abstract class AbstractRestServiceRepository extends AbstractRestRepository
{
    public function __construct(
        RegistryInterface $registry
    ) {
        parent::__construct(
            $registry->getSerializer(),
        );
    }
}