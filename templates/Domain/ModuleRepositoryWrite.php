<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Domain;

use Seavices\Backoffice\%modules%\Domain\%module%Write;
use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;

interface %module%RepositoryWrite
{
    public function save(%module%Write $entity): void;

    public function find(%module%Id $id): ?%module%Write;

    public function delete(%module%Id $id): void;
}

