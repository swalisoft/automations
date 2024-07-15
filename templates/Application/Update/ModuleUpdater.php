<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Update;

use Seavices\Backoffice\%modules%\Domain\%module%NotExist;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryWrite;
%uses%

final class %module%Updater
{
    private $repository;

    public function __construct(%module%RepositoryWrite $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
		%params%
    ) {
        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new %module%NotExist();
        }

		%entitySetters%

        $this->repository->save($entity);
    }
}
