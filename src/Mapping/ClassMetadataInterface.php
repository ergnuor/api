<?php
declare(strict_types=1);

namespace Ergnuor\Api\Mapping;

interface ClassMetadataInterface
{
    public function getRepositoryClass(): string;

    public function getPersisterClass(): ?string;

    public function getClassName(): string;
}