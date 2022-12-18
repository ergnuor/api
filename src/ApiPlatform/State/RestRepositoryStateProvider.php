<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\ApiPlatform\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use Ergnuor\ApiPlatform\EntityManager\RestEntityManagerInterface;

class RestRepositoryStateProvider implements \ApiPlatform\State\ProviderInterface
{
    private RestEntityManagerInterface $restEntityManager;
    private \ApiPlatform\State\Pagination\Pagination $pagination;

    public function __construct(
        RestEntityManagerInterface $restEntityManager,
        \ApiPlatform\State\Pagination\Pagination $pagination
    ) {
        $this->restEntityManager = $restEntityManager;
        $this->pagination = $pagination;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$this->restEntityManager->getClassMetadataFactory()->hasMetadataFor($operation->getClass())) {
            return null;
        }

        $repository = $this->restEntityManager->getRepositoryForClass($operation->getClass());

        if (
            $operation instanceof \ApiPlatform\Metadata\Get ||
            $operation instanceof \ApiPlatform\Metadata\Patch ||
            $operation instanceof \ApiPlatform\Metadata\Delete
        ) {

//            dd([
//                $operation,
////                $context,
//            ]);

            //todo брать идентификатор из данных об операции или метаданных ресурса
            if (!isset($uriVariables['id'])) {
                throw new \RuntimeException("Identifier with name 'id' expected");
            }

            return $repository->getItem($uriVariables['id']);
        }

        if ($operation instanceof \ApiPlatform\Metadata\GetCollection) {
            /**
             * todo учесть различные настройки пагинации https://api-platform.com/docs/core/pagination/
             */
            [$page, $offset, $limit] = $this->pagination->getPagination($operation, $context);

            return new TraversablePaginator(
                new \ArrayIterator(
                    $repository->getList($limit, $offset)
                ),
                $page,
                $limit,
                $repository->getTotalItems()
            );

//            dd([
//                $repository->getTotalItems(),
//                $repository->getList($limit, $offset),
//            ]);

//            dd([
//                [$page, $offset, $limit],
//                $this->pagination,
//            ]);
//            dd('Done');
        }


//        dd(
//            $repository
//        );

//        dd([
//            get_debug_type($this),
//            get_debug_type($operation),
//            Debug::getBacktrace(),
//            $uriVariables,
//            $operation,
////            $context,
//        ]);

        return null;
    }
}