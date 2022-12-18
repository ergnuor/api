<?php

declare(strict_types=1);

namespace Ergnuor\ApiPlatform\ApiPlatform\Metadata\Resource\Factory;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\HttpOperation;
use ApiPlatform\Metadata\Operations;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Metadata\Resource\ResourceMetadataCollection;
use Ergnuor\ApiPlatform\EntityManager\RestEntityManagerInterface;
use Ergnuor\ApiPlatform\ApiPlatform\State\RestRepositoryStateProcessor;
use Ergnuor\ApiPlatform\ApiPlatform\State\RestRepositoryStateProvider;

final class UriTemplateResourceMetadataCollectionFactory implements ResourceMetadataCollectionFactoryInterface
{
    private ResourceMetadataCollectionFactoryInterface $decorated;
    private RestEntityManagerInterface $restEntityManager;

    public function __construct(
        ResourceMetadataCollectionFactoryInterface $decorated,
        RestEntityManagerInterface $restEntityManager
    ) {
        $this->decorated = $decorated;
        $this->restEntityManager = $restEntityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $resourceClass): ResourceMetadataCollection
    {
        $resourceMetadataCollection = $this->decorated->create($resourceClass);

        $classMetadataFactory = $this->restEntityManager->getClassMetadataFactory();

        foreach ($resourceMetadataCollection as $i => $resource) {
            /** @var ApiResource $resource */

            $resourceClassName = $resource->getClass();

            if (!$classMetadataFactory->hasMetadataFor($resourceClassName)) {
                continue;
            }

//            $routePrefix = $resource->getRoutePrefix();
//            $resource = $resource->withRoutePrefix('');

//            dump([
//                get_debug_type($resource),
//                $resource->getClass(),
//                $resource->getProvider(),
//                $resource->getProcessor(),
////                Debug::getBacktrace(),
//            ]);

            $classMetadata = $classMetadataFactory->getMetadataFor($resourceClassName);

            $stateProvider = $resource->getProvider();
            if ($stateProvider === null) {
                $stateProvider = RestRepositoryStateProvider::class;
                $resource = $resource->withProvider($stateProvider);
            }

            $stateProcessor = $resource->getProcessor();
            if (
                $stateProcessor === null &&
                $classMetadata->getPersisterClass() !== null
            ) {
                $stateProcessor = RestRepositoryStateProcessor::class;
                $resource = $resource->withProcessor($stateProcessor);
            }

//            dump([
//                $resource->getProvider(),
//                $resource->getProcessor(),
//            ]);

            $operations = new Operations();
            foreach ($resource->getOperations() ?? new Operations() as $key => $operation) {
                /** @var HttpOperation $operation */
//                dump([
//                    get_debug_type($operation),
//                    $operation->getProvider()
//                ]);

                if ($operation instanceof Post) {
                    $operation = $operation->withRead($operation->canRead() ?? false);
                }

                if ($operation->getProvider() === null) {
                    $operation = $operation->withProvider($stateProvider);
                }

                if (
                    $operation->getProcessor() === null &&
                    $stateProcessor !== null
                ) {
                    $operation = $operation->withProcessor($stateProcessor);
                }

                $operations->add($key, $operation);
            }

            $resource = $resource->withOperations($operations->sort());
            $resourceMetadataCollection[$i] = $resource;
        }

//        dd('Done');

        return $resourceMetadataCollection;
    }
}
