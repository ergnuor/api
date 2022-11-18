<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 * @deprecated Похоже на ранние и уже неиспользуемые наработки
 */
abstract class AbstractDataPersister implements ContextAwareDataPersisterInterface
{
    final public function persist($data, array $context = [])
    {
        $this->beforeOperation();

        if (($context['collection_operation_name'] ?? null) == 'post') {
            return $this->doCreate($data, $context);
        }

        if (($context['item_operation_name'] ?? null) == 'patch') {
            return $this->doUpdate($data, $context);
        }

        throw new \RuntimeException('Unknown persistence operation');
    }

    abstract protected function doCreate($data, array $context = []): object;

    abstract protected function doUpdate($data, array $context = []): object;

    final public function remove($data, array $context = [])
    {
        $this->beforeOperation();

        $this->doRemove($data, $context);
    }

    abstract protected function doRemove($data, array $context = []): void;

    protected function beforeOperation()
    {
    }

    public function supports($data, array $context = []): bool
    {
        return is_a($data, $this->getResourceType());
    }

    abstract protected function getResourceType(): string;
}