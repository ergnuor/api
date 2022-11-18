<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\PaginatorInterface;

trait CollectionPaginatedDataProviderTrait
{
    use CollectionDataProviderTrait;

    protected function createPaginator(array $context, int $page, int $limit): PaginatorInterface
    {
        return new CallbackPaginator(
            \Closure::fromCallable([$this, 'getTotalItems']),
            \Closure::fromCallable([$this, 'getResourceIterator']),
            $context,
            $page,
            $limit,
        );
    }

    private function getResourceIterator(int $itemsPerPage, int $offset, array $context): \Traversable
    {
        $list = $this->getSourceList($itemsPerPage, $offset, $context);

        return new \ArrayIterator($list);
    }

    abstract protected function getSourceList(int $itemsPerPage, int $offset, array $context): array;

    abstract protected function getTotalItems(array $context): float;
}