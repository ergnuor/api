<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform;

trait ContextTrait
{
    protected function getResourceClassFromContext(array $context)
    {
        return $context['resource_class'];
    }
}