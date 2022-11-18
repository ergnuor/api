<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

class CallbackPaginator extends AbstractPaginator
{
    /**
     * @var callable
     */
    private $getTotalItemsCallback;
    /**
     * @var callable
     */
    private $getResourceIterator;

    public function __construct(
        callable $getTotalItemsCallback,
        callable $getResourceIterator,
        array $context,
        int $currentPage,
        int $maxResults
    ) {
        parent::__construct($context, $currentPage, $maxResults
        );

        $this->getTotalItemsCallback = $getTotalItemsCallback;
        $this->getResourceIterator = $getResourceIterator;
    }

    protected function doGetTotalItems(): float
    {
        return call_user_func_array($this->getTotalItemsCallback, [$this->context]);
    }

    protected function getResourceIterator(int $itemsPerPage, int $offset, array $context): \Traversable
    {
        return call_user_func_array($this->getResourceIterator, [$itemsPerPage, $offset, $context]);
    }
}