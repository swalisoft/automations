<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Domain;

use Seavices\Shared\Domain\Aggregate\AggregateRoot;
%uses%
final class %module%Write extends AggregateRoot
{
	%attributes%

	public function __construct(
%params%
	) {
%assignValue%
	}

	public static function create(
%params%
	): self {
		$entity = new self(%rawParams%);

		$entity->record(
			new %module%CreatedDomainEvent(
				$id->value(),
				$name->value(),
			)
		);

		return $entity;
	}
	%getters%
	%setters%
}
