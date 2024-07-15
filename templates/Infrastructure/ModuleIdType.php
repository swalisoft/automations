<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Infrastructure\Persistence\Mappings;

use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;
use Seavices\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class %module%IdType extends UuidType
{
  public static function customTypeName(): string
  {
    return '%rawModule%_id';
  }

  protected function typeClassName(): string
  {
    return %module%Id::class;
  }
}
