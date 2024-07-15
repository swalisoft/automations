<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Domain;

use Seavices\Shared\Domain\Criteria\Criteria;
use Seavices\Backoffice\Shared\Domain\%module%\%module%Id;

interface %module%RepositoryRead
{
	public function matching(Criteria $criteria):array;

	public function searchAll(): array;
	
	public function find(%module%Id $id): ?%module%Read;

}

