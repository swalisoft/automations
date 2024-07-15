<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Update;

use Seavices\Shared\Domain\Bus\Command\CommandHandler;
%uses%

final class Update%module%CommandHandler implements CommandHandler
{
    private $updater;

    public function __construct(%module%Updater $updater)
    {
        $this->updater = $updater;
    }

    public function __invoke(Update%module%Command $command)
    {
		%assignValue%

        $this->updater->__invoke(%rawParams%);
    }
}
