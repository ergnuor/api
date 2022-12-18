<?php
declare(strict_types=1);

namespace Ergnuor\Api\Persister;

interface RestPersisterInterface
{
    public function persist($data);
    public function remove($data);
}