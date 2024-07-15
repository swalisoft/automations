<?php

declare(strict_types=1);

namespace Seavices\Backoffice\%modules%\Application\Create;

use Seavices\Shared\Domain\Bus\\Event\\EventBus;
use Seavices\Backoffice\%modules%\Domain\%module%Write;
use Seavices\Backoffice\%modules%\Domain\%module%AlreadyExists;
use Seavices\Backoffice\%modules%\Domain\%module%RepositoryWrite;
%uses%
final class %module%Creator
{
	private $repository;
	private $bus;

	public function __construct(
		%module%RepositoryWrite $repository,
		EventBus $busMemory
	) {
			$this->repository = $repository;
			$this->bus        = $busMemory;
	}

	public function __invoke(
		%params%
	) {
		$entity = $this->repository->find($id);

		if (!is_null($entity)) {
			throw new %module%AlreadyExists();
		}

		$model = %module%Write::create(%rawParams%);

		$this->repository->save($model);
		$this->bus->publish(...$model->pullDomainEvents());
	}
}
