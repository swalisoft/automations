<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Domain;

use Seavices\Shared\Domain\Bus\\Event\DomainEvent;

final class %module%CreatedDomainEvent extends DomainEvent
{
	%attributes%

    public function __construct(
        string $id,
        string $name,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);

        $this->id = $id;
        $this->name = $name;
    }

    public static function eventName(): string
    {
        return '%lowModules%.created';
    }

    public function toPrimitives(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn,
        string $deleteDate
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['name'],
            $eventId,
            $occurredOn
        );
    }
}
