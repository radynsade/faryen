<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Application;

use App\Languages\Domain\Language\Code;
use App\Languages\Domain\Language\EnglishName;
use App\Languages\Domain\Language\Event\LanguageCreatedEvent;
use App\Languages\Domain\Language\Exception\CodeAlreadyExistsException;
use App\Languages\Domain\Language\Language;
use App\Languages\Domain\Language\NativeName;
use App\Languages\Domain\Language\Repository as LanguageRepository;
use Psr\Clock\ClockInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CreateLanguage {
	public function __construct(
		private LanguageRepository $languageRepository,
		private EventDispatcher $eventDispatcher,
		private ClockInterface $clock,
	) {
	}

	public function __invoke(
		string $code,
		string $englishName,
		string $nativeName,
		bool $isFallback,
	): void {
		$languageCode = new Code($code);
		$languageRepository = $this->languageRepository;

		if ($languageRepository->existsByCode($languageCode)) {
			throw new CodeAlreadyExistsException($languageCode);
		}

		$language = new Language(
			new Code($code),
			new NativeName($nativeName),
			new EnglishName($englishName),
			$isFallback,
		);

		$languageRepository->create($language);
		$this->eventDispatcher->dispatch(new LanguageCreatedEvent($language, $this->clock->now()));
	}
}
