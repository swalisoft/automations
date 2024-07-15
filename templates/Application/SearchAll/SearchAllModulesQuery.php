<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\SearchAll;

use Seavices\Shared\Domain\Bus\Query\Query;

final class SearchAll%modules%Query implements Query
{
    private $filter;
    private $orderBy;
    private $order;
    private $offset;
    private $limit;

    public function __construct(
        array $filter = [],
        string $orderBy = null,
        string $order = null,
        int $offset = null,
        int $limit = null
    ) {
        $this->order  = $order;
        $this->limit  = $limit;
        $this->filter  = $filter;
        $this->offset  = $offset;
        $this->orderBy  = $orderBy;
    }

    public function filter(): array
    {
        return $this->filter;
    }
    public function orderBy(): ?string
    {
        return $this->orderBy;
    }
    public function order(): ?string
    {
        return $this->order;
    }
    public function offset(): ?int
    {
        return $this->offset;
    }
    public function limit(): ?int
    {
        return $this->limit;
    }
}
