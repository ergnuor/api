<?php

declare(strict_types=1);

namespace Ergnuor\Api\Request;

interface RequestInterface
{
    public function getRouteParams(): array;

    public function getRouteParam(string $paramName): ?string;

    public function hasRouteParam(string $paramName): bool;
}