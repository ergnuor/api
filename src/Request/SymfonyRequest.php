<?php

declare(strict_types=1);

namespace Ergnuor\Api\Request;

use Symfony\Component\HttpFoundation\RequestStack;

class SymfonyRequest implements RequestInterface
{
    protected RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getRouteParams(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request->attributes->get('_route_params');
    }

    public function getRouteParam(string $paramName): ?string
    {
        $routeParameters = $this->getRouteParams();

        if (isset($routeParameters[$paramName])) {
            return $routeParameters[$paramName];
        }

        return null;
    }

    public function hasRouteParam(string $paramName): bool
    {
        $routeParameters = $this->getRouteParams();

        return isset($routeParameters[$paramName]);
    }
}