<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application;

use Seavices\Shared\Domain\Bus\Query\Response;

final class %module%Response implements Response
{
    %attributes%

	public function __construct(
        %params%
	) {
        %assignValue%
    }

	%getters%

    public function toArray(): array
    {
        return [
            %toArray%
        ];
    }
}
