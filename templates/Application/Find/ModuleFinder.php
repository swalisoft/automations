<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Find;

use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;
use Seavices\Backoffice\%modules%\Domain\%module%NotExist;
use Seavices\Backoffice\%modules%\Application\%module%Response;
use Seavices\Backoffice\%modules%\Domain\%module%CreateResponse;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryRead;

final class %module%Finder
{
    private $repository;

    public function __construct(%module%RepositoryRead $repository)
    {
        $this->repository = $repository;
    }

    public function find(%module%Id $id): %module%Response
    {
        $entity = $this->repository->find($id);
        
        if (null === $entity) {
            throw new %module%NotExist();
        }

        return %module%CreateResponse::create($entity);
    }
}
