<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Infrastructure\Persistence;

use Seavices\Backoffice\%modules%\Domain\%module%Write;
use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryWrite;
use Seavices\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySql%module%RepositoryWrite extends DoctrineRepository implements %module%RepositoryWrite
{
  public function save(%module%Write $entity): void
  {
    $this->persist($entity);
  }

  public function find(%module%Id $id): ?%module%Write
  {
    return $this->repository(%module%Write::class)->find($id);
  }

  public function delete(%module%Id $id): void
  {
    $entity = $this->repository(%module%Write::class)->find($id);

    if ($entity) {
      $this->remove($entity);
    }
  }
}
