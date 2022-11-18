<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\DataProvider\PaginatorInterface;

trait CollectionDataProviderTrait
{
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        [$page, $offset, $limit] = $this->getPagination()->getPagination($resourceClass, $operationName, $context);

        $this->beforeOperation();

        return $this->createPaginator($context, (int)$page, (int)$limit);
    }

    abstract protected function beforeOperation();

    abstract protected function getPagination(): Pagination;

    abstract protected function createPaginator(array $context, int $page, int $limit): PaginatorInterface;
}