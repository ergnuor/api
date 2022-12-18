<?php

declare(strict_types=1);

namespace Ergnuor\Api\Repository;

use Ergnuor\Api\RegistryInterface;

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