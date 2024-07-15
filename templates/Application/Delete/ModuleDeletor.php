<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Delete;

use Seavices\Backoffice\%modules%\Domain\%module%NotExist;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryWrite;
use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;

final class %module%Deletor
{
    private $repository;

    public function __construct(%module%RepositoryWrite $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(%module%Id $id): void
    {
        $model = $this->repository->find($id);

        if (null === $model) {
            throw new %module%NotExist();
        }

        $this->repository->delete($id);
    }
}
