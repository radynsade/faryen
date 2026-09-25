<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Infrastructure\Doctrine\Repository;

use App\Doctrine\EntityRepository;
use App\Languages\Domain\Language\Code;
use App\Languages\Domain\Language\Exception\LanguageNotFoundException;
use App\Languages\Domain\Language\Language as DomainLanguage;
use App\Languages\Domain\Language\Repository;
use App\Languages\Infrastructure\Doctrine\Entity\Language;
use Doctrine\Persistence\ManagerRegistry;
use Override;

/**
 * @extends EntityRepository<Language>
 */
class LanguageRepository extends EntityRepository implements Repository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Language::class);
	}

	#[Override]
	public function existsByCode(Code $code): bool {
		return $this->existsBy(['code' => $code->getValue()]);
	}

	#[Override]
	public function create(DomainLanguage $language): void {
		$entity = new Language();
		$entity->setCode($language->getCode()->getValue());
		$entity->setEnglishName($language->getEnglishName()->getValue());
		$entity->setNativeName($language->getNativeName()->getValue());
		$entityManager = $this->getEntityManager();
		$entityManager->persist($entity);
		$entityManager->flush();
		$entityManager->clear();
	}

	#[Override]
	public function delete(DomainLanguage $language): void {
		$entityManager = $this->getEntityManager();
		$entityManager->wrapInTransaction(function () use ($entityManager, $language): void {
			$entity = $this->reserveOneBy(['code' => $language->getCode()->getValue()]);
			if ($entity === null) {
				throw new LanguageNotFoundException($language->getCode());
			}

			$entityManager->remove($entity);
		});
		$entityManager->clear();
	}
}
