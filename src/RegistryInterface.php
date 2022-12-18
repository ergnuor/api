<?php
declare(strict_types=1);

namespace Ergnuor\Api;

use Ergnuor\Api\EntityManager\RestEntityManagerInterface;
use Ergnuor\Api\Request\RequestInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface RegistryInterface
{
    public function getEntityManager(): RestEntityManagerInterface;

    public function getSerializer(): Serializer;

    public function getValidator(): ValidatorInterface;

    public function getRequest(): RequestInterface;
}