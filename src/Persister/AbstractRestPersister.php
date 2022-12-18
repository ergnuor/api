<?php

declare(strict_types=1);

namespace Ergnuor\Api\Persister;

use Ergnuor\Api\EntityManager\RestEntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRestPersister implements RestPersisterInterface
{
    protected ValidatorInterface $validator;
    protected RestEntityManagerInterface $restEntityManager;

    public function __construct(
        RestEntityManagerInterface $restEntityManager,
        ValidatorInterface $validator
    ) {
        $this->restEntityManager = $restEntityManager;
        $this->validator = $validator;
    }

    final public function persist($data)
    {
        $this->validator->validate($data);

        $this->beforeOperation();
        $id = $this->doPersist($data);

        if ($id === null) {
            return null;
        }

        $restRepository = $this->restEntityManager->getRepositoryForClass($this->getResourceClass());

        return $restRepository->getItem($id);
    }

    abstract protected function getResourceClass(): string;

    protected function beforeOperation()
    {

    }

    abstract protected function doPersist($data): ?int;

    final public function remove($data)
    {
        $this->beforeOperation();
        $this->doRemove($data);
    }

    abstract protected function doRemove($data): void;
}