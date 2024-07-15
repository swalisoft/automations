<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Delete;

use Seavices\Shared\Domain\Bus\Command\Command;

final class Delete%module%Command implements Command
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }
}
