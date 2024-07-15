<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Infrastructure\Persistence;

use Seavices\Shared\Domain\Criteria\Criteria;
use Seavices\Backoffice\%modules%\Domain\%module%Read;
use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryRead;
use Seavices\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Seavices\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;

final class MySql%module%RepositoryRead extends DoctrineRepository implements %module%RepositoryRead
{
    public function searchAll(): array
    {
        return $this->repository(%module%Read::class)->findAll();
    }

    public function matching(Criteria $criteria): array
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        return $this->repository(%module%Read::class)->matching($doctrineCriteria)->toArray();
    }

    public function find(%module%Id $id): ?%module%Read
    {
        return $this->repository(%module%Read::class)->find($id);
    }
}
