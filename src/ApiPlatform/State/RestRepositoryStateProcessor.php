<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\ApiPlatform\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Ergnuor\ApiPlatform\EntityManager\RestEntityManagerInterface;

class RestRepositoryStateProcessor implements ProcessorInterface
{
    private RestEntityManagerInterface $restEntityManager;

    public function __construct(
        RestEntityManagerInterface $restEntityManager
    ) {
        $this->restEntityManager = $restEntityManager;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!$this->restEntityManager->getClassMetadataFactory()->hasMetadataFor($operation->getClass())) {
            return null;
        }

        $persister = $this->restEntityManager->getPersisterForClass($operation->getClass());

        if (
            $operation instanceof \ApiPlatform\Metadata\Post ||
            $operation instanceof \ApiPlatform\Metadata\Patch
        ) {

            //todo убедиться, что при PATCH в данных есть идентификатор сущности
//            dd([
//                $data,
//                $uriVariables,
//                $operation,
//            ]);
            return $persister->persist($data);
        }

        if ($operation instanceof \ApiPlatform\Metadata\Delete) {
//            dd(__METHOD__);

            return $persister->remove($data);
        }

//        dd([
//            $data,
//            $uriVariables,
//            $operation
//        ]);

        return null;
    }
}