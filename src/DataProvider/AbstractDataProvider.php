<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Ergnuor\ApiPlatform\ContextTrait;

abstract class AbstractDataProvider implements ContextAwareCollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    use ItemDataProviderTrait;
    use CollectionPaginatedDataProviderTrait;
    use ContextTrait;

    private Pagination $pagination;

    public function __construct(
        Pagination $pagination
    ) {
        $this->pagination = $pagination;
    }

    protected function getPagination(): Pagination
    {
        return $this->pagination;
    }

    protected function beforeOperation()
    {
    }
}