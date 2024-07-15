<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\SearchAll;

use Seavices\Backoffice\%modules%\Application\%modules%Response;
use Seavices\Backoffice\%modules%\Domain\%module%CreateResponse;
use Seavices\Backoffice\%modules%\Domain\%module%Read;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryRead;

use function Lambdish\Phunctional\map;

final class All%modules%Searcher
{
    private $repository;

    public function __construct(%module%RepositoryRead $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($criteria): %modules%Response
    {
        $result = $this->repository->matching($criteria);

        return new %modules%Response(
            ...map($this->toResponse(), $result)
        );
    }

    private function toResponse(): callable
    {
        return static function (%module%Read $entity) {
            return %module%CreateResponse::create($entity);
        };
    }
}
