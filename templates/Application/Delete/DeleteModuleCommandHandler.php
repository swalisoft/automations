<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Delete;

use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;
use Seavices\Shared\Domain\Bus\Command\CommandHandler;

final class Delete%module%CommandHandler implements CommandHandler
{
    private $deletor;

    public function __construct(%module%Deletor $deletor)
    {
        $this->deletor = $deletor;
    }

    public function __invoke(Delete%module%Command $command): void
    {
        $id = new %module%Id($command->id());
        $this->deletor->__invoke($id);
    }
}
