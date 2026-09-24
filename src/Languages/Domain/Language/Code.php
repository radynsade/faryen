<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language;

use App\Security\Exception\InvalidLanguageCodeException;
use Symfony\Component\Intl\Languages;

class Code {
	public function __construct(private string $value) {
		if (!Languages::exists($value)) {
			throw new InvalidLanguageCodeException($value);
		}
	}

	public function getValue(): string {
		return $this->value;
	}
}
