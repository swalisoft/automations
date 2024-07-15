<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\SearchAll;

use Seavices\Shared\Domain\Bus\Query\QueryHandler;
use Seavices\Shared\Domain\Criteria\Filters;
use Seavices\Shared\Domain\Criteria\Order;
use Seavices\Shared\Domain\Criteria\Criteria;

final class SearchAll%modules%QueryHandler implements QueryHandler
{
    private $searchAll;

    public function __construct(All%modules%Searcher $searchAll)
    {
        $this->searchAll = $searchAll;
    }

    public function __invoke(SearchAll%modules%Query $query)
    {
        $filters    = Filters::fromValues($query->filter());
        $order      = Order::fromValues($query->orderBy(), $query->order());
        $offset     = $query->offset();
        $limit      = $query->limit();

        $criteria = new Criteria($filters, $order, $offset, $limit);

        return $this->searchAll->__invoke($criteria);
    }
}
