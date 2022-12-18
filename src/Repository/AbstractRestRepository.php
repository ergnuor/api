<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Repository;

use ApiPlatform\Api\CompositeIdentifierParser;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractRestRepository implements RestRepositoryInterface
{
    protected Serializer $serializer;

    public function __construct(
        Serializer $serializer
    ) {
        $this->serializer = $serializer;
    }

    final public function getTotalItems(): int
    {
        $this->beforeOperation();
        return $this->doGetTotalItems();
    }

    protected function beforeOperation()
    {

    }

    abstract protected function doGetTotalItems(): int;

    final public function getList(int $itemsPerPage, int $offset, array $filter = [], array $orderBy = null): array
    {
        $this->beforeOperation();
        $list = $this->doGetList($itemsPerPage, $offset, $filter, $orderBy);

        $list = $this->normalizeList($list);
        $list = $this->mapList($list);
        return $this->denormalizeList($list);
    }

    abstract protected function doGetList(
        int $itemsPerPage,
        int $offset,
        array $filter = [],
        array $orderBy = null
    ): array;

    private function normalizeList(array $list): array
    {
        foreach ($list as $key => $item) {
            $list[$key] = $this->normalizeIfObject($item);
        }

        return $list;
    }

    private function normalizeIfObject($item)
    {
        return is_object($item) ? $this->serializer->normalize($item) : $item;
    }

    /**
     * @param array[][] $list
     * @return array[][]
     */
    protected function mapList(array $list): array
    {
        return $list;
    }

    private function denormalizeList(array $list): array
    {
        return $this->serializer->denormalize($list, $this->getResourceClass() . '[]');
    }

    final public function getItem($id)
    {
        if (is_string($id)) {
            $id = CompositeIdentifierParser::parse($id);
        }

        $this->beforeOperation();
        $item = $this->doGetItem($id);

        if ($item === null) {
            return null;
        }

        $item = $this->normalizeIfObject($item);
        $item = $this->mapItem($item);
        return $this->serializer->denormalize($item, $this->getResourceClass());
    }

    abstract protected function doGetItem($id);

    protected function mapItem(array $item): array
    {
        return $this->mapList([$item])[0];
    }
}