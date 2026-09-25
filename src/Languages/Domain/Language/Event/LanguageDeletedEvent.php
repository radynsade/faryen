<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language\Event;

use App\Languages\Domain\Language\Language;
use DateTimeInterface;

class LanguageDeletedEvent {
	public function __construct(
		private readonly Language $language,
		private readonly DateTimeInterface $occurredAt,
	) {
	}

	public function getLanguage(): Language {
		return $this->language;
	}

	public function getOccurredAt(): DateTimeInterface {
		return $this->occurredAt;
	}
}
