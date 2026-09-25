<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language\Exception;

use App\Languages\Domain\Language\Code;
use RuntimeException;

class LanguageNotFoundException extends RuntimeException {
	public function __construct(private readonly Code $languageCode) {
		parent::__construct(sprintf('Language with code "%s" does not exist', $languageCode->getValue()));
	}

	public function getLanguageCode(): Code {
		return $this->languageCode;
	}
}
