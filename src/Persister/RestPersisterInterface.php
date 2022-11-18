<?php
declare(strict_types=1);

namespace Ergnuor\ApiPlatform\Persister;

interface RestPersisterInterface
{
    public function persist($data);
    public function remove($data);
}