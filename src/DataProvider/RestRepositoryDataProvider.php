<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\Pagination;
use Ergnuor\ApiPlatform\EntityManager\RestEntityManagerInterface;
use Ergnuor\ApiPlatform\Repository\RestRepositoryInterface;

class RestRepositoryDataProvider extends AbstractDataProvider
{
    private RestEntityManagerInterface $restEntityManager;

    public function __construct(
        RestEntityManagerInterface $restEntityManager,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);

        $this->restEntityManager = $restEntityManager;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        $classNames = array_flip($this->restEntityManager->getClassMetadataFactory()->getAllClassNames());
        return isset($classNames[$resourceClass]);
    }

    protected function getTotalItems(array $context): float
    {
        return (float)$this->getRepository($context)->getTotalItems();
    }

    private function getRepository(array $context): RestRepositoryInterface
    {
        $resourceClass = $this->getResourceClassFromContext($context);
        return $this->restEntityManager->getRepositoryForClass($resourceClass);
    }

    protected function getSourceList(int $itemsPerPage, int $offset, array $context): array
    {
        return $this->getRepository($context)->getList($itemsPerPage, $offset);
    }

    protected function doGetItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->getRepository($context)->getItem($id);
    }
}