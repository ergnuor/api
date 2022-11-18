<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataProvider;

use Symfony\Component\Serializer\Serializer;

trait ItemDataProviderTrait
{
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $this->beforeOperation();

        $item = $this->doGetItem($resourceClass, $id, $operationName, $context);

        if ($item === null) {
            return null;
        }

        return $item;
    }

    abstract protected function beforeOperation();

    abstract protected function doGetItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    );
}