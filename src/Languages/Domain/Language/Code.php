<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language;

use App\Languages\Domain\Language\Exception\InvalidCodeException;
use Symfony\Component\Intl\Languages;

class Code {
	public function __construct(private string $value) {
		if (!Languages::exists($value)) {
			throw new InvalidCodeException($value);
		}
	}

	public function getValue(): string {
		return $this->value;
	}
}
