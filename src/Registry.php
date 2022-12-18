<?php
declare(strict_types=1);

namespace Ergnuor\Api;

use Ergnuor\Api\EntityManager\RestEntityManagerInterface;
use Ergnuor\Api\Request\RequestInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Registry implements RegistryInterface
{
    private RestEntityManagerInterface $restEntityManager;
    private Serializer $serializer;
    private ValidatorInterface $validator;
    private RequestInterface $request;

    public function __construct(
        RestEntityManagerInterface $restEntityManager,
        Serializer $serializer,
        ValidatorInterface $validator,
        Request\RequestInterface $request
    ) {
        $this->restEntityManager = $restEntityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->request = $request;
    }

    public function getEntityManager(): RestEntityManagerInterface
    {
        return $this->restEntityManager;
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}