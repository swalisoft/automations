<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Create;

use Seavices\Shared\Domain\Bus\Command\Command;
%uses%

final class Create%module%Command implements Command
{
	%attributes%

	public function __construct(
%params%
	) {
%assignValue%
	}

	%getters%
}
