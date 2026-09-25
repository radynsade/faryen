<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language\Event;

use App\Languages\Domain\Language\Language;
use DateTimeInterface;

class LanguageCreatedEvent {
	public function __construct(
		private readonly Language $language,
		private DateTimeInterface $occurredAt,
	) {
	}

	public function getLanguage(): Language {
		return $this->language;
	}

	public function getOccurredAt(): DateTimeInterface {
		return $this->occurredAt;
	}
}
