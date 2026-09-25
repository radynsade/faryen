<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language\Exception;

use App\Languages\Domain\Language\Code;
use RuntimeException;

class CodeAlreadyExistsException extends RuntimeException {
	public function __construct(private Code $languageCode) {
		parent::__construct(sprintf('Language with code "%s" already exists', $languageCode->getValue()));
	}

	public function getLanguageCode(): Code {
		return $this->languageCode;
	}
}
