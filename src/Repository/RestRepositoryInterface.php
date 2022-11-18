<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Repository;

interface RestRepositoryInterface
{
    public function getTotalItems(): int;

    public function getList(int $itemsPerPage, int $offset, array $filter = [], array $orderBy = null): array;

    public function getItem($id);

    public function getResourceClass(): string;
}