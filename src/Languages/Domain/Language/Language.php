<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language;

class Language {
	public function __construct(
		private Code $code,
		private NativeName $nativeName,
		private EnglishName $englishName,
		private bool $isFallback,
	) {
	}

	public function getCode(): Code {
		return $this->code;
	}

	public function getNativeName(): NativeName {
		return $this->nativeName;
	}

	public function getEnglishName(): EnglishName {
		return $this->englishName;
	}

	public function isFallback(): bool {
		return $this->isFallback;
	}
}
