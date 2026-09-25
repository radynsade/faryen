<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language;

use App\Languages\Domain\Language\Exception\InvalidEnglishNameException;

class EnglishName {
	public function __construct(private string $value) {
		if (mb_strlen($value) > 50) {
			throw new InvalidEnglishNameException($value);
		}
	}

	public function getValue(): string {
		return $this->value;
	}
}
