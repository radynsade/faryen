<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Text;

use App\Languages\Domain\Language\Code;

class Translation {
	public function __construct(
		private Code $languageCode,
		private string $content,
	) {
	}

	public function getLanguageCode(): Code {
		return $this->languageCode;
	}

	public function getContent(): string {
		return $this->content;
	}
}
