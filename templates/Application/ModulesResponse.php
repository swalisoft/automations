<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application;

use function Lambdish\Phunctional\map;
use Seavices\Shared\Domain\Bus\Query\Response;
use Seavices\Backoffice\%modules%\Application\%module%Response;

final class %modules%Response implements Response
{
    private $models;

    public function __construct(%module%Response ...$models)
    {
        $this->models = $models;
    }

    public function models(): array
    {
        return $this->models;
    }

    public function toArray(): array
    {
        return map($this->toArrayMap(), $this->models());
    }

    protected function toArrayMap()
    {
        return static function (%module%Response $response) {
            return $response->toArray();
        };
    }
}
