<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Create;

use Seavices\Shared\Domain\Bus\Command\CommandHandler;
%uses%
final class Create%module%CommandHandler implements CommandHandler
{
	private $creator;

	public function __construct(%module%Creator $creator)
	{
		$this->creator = $creator;
	}

	public function __invoke(Create%module%Command $command)
	{
		%assignValue%

		$this->creator->__invoke(%rawParams%);
	}
}
