<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

use ApiPlatform\Core\DataProvider\PaginatorInterface;

abstract class AbstractPaginator implements PaginatorInterface, \IteratorAggregate
{
    protected array $context;
    private $iterator = null;
    private int $currentPage;
    private int $maxResults;

    private ?float $cachedTotalItems = null;

    public function __construct(
        array $context,
        int $currentPage,
        int $maxResults
    ) {
        $this->context = $context;
        $this->currentPage = $currentPage;
        $this->maxResults = $maxResults;
    }

    public function reset()
    {
        $this->cachedTotalItems = null;
    }

    public function count(): int
    {
        return \iterator_count($this->getIterator());
    }

    public function getLastPage(): float
    {
        return \ceil($this->getTotalItems() / $this->getItemsPerPage()) ?: 1.;
    }

    public function getItemsPerPage(): float
    {
        return $this->maxResults;
    }

    public function getIterator(): \Traversable
    {
        if ($this->iterator === null) {
            $offset = (($this->getCurrentPage() - 1) * $this->getItemsPerPage());
            $this->iterator = $this->getResourceIterator((int)$this->getItemsPerPage(), (int)$offset, $this->context);
        }

        return $this->iterator;
    }

    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    final public function getTotalItems(): float
    {
        if ($this->cachedTotalItems === null) {
            $this->cachedTotalItems = $this->doGetTotalItems();
        }

        return $this->cachedTotalItems;
    }

    abstract protected function doGetTotalItems(): float;

    abstract protected function getResourceIterator(int $itemsPerPage, int $offset, array $context): \Traversable;
}