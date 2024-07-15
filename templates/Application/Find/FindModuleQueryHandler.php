<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Find;

use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;
use Seavices\Backoffice\%modules%\Application\Find\%module%Finder;
use Seavices\Shared\Domain\Bus\Query\QueryHandler;

final class Find%module%QueryHandler implements QueryHandler
{
    private $finder;

    public function __construct(%module%Finder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(Find%module%Query $query)
    {
        $id = new %module%Id($query->id());

        return $this->finder->find($id);
    }
}
