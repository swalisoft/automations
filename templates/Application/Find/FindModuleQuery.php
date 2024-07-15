<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Find;

use Seavices\Shared\Domain\Bus\Query\Query;

final class Find%module%Query implements Query
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}
