<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language;

use App\Security\Exception\InvalidLanguageEnglishNameException;

class EnglishName {
	public function __construct(private string $value) {
		if (mb_strlen($value) > 50) {
			throw new InvalidLanguageEnglishNameException($value);
		}
	}

	public function getValue(): string {
		return $this->value;
	}
}
