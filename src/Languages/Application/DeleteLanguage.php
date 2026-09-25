<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Application;

use App\Languages\Domain\Language\Event\LanguageDeletedEvent;
use App\Languages\Domain\Language\Language;
use App\Languages\Domain\Language\Repository as LanguageRepository;
use Psr\Clock\ClockInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class DeleteLanguage {
	public function __construct(
		private LanguageRepository $languageRepository,
		private EventDispatcherInterface $eventDispatcher,
		private ClockInterface $clock,
	) {
	}

	public function __invoke(Language $language): void {
		$this->languageRepository->delete($language);
		$this->eventDispatcher->dispatch(new LanguageDeletedEvent($language, $this->clock->now()));
	}
}
