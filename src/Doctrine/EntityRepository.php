<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;

/**
 * @template T of object
 * @extends ServiceEntityRepository<T>
 */
abstract class EntityRepository extends ServiceEntityRepository {
	/**
	 * Query the entity with pessimistic write lock by the given criteria.
	 * @param array<string,mixed> $criteria
	 * @return T|null
	 */
	public function reserveOneBy(array $criteria): ?object {
		return $this->getEntityManager()
			->getUnitOfWork()
			->getEntityPersister($this->getEntityName())
			->load(
				criteria: $criteria,
				lockMode: LockMode::PESSIMISTIC_WRITE,
				limit: 1,
			);
	}

	/**
	 * @param array<string,mixed> $criteria
	 */
	public function existsBy(array $criteria): bool {
		return $this->getEntityManager()
			->getUnitOfWork()
			->getEntityPersister($this->getEntityName())
			->load(
				criteria: $criteria,
				limit: 1,
			) !== null;
	}
}
