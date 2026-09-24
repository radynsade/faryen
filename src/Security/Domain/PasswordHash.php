<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Security\Domain;

use App\Security\Exception\InvalidPasswordHashException;

class PasswordHash {
	public function __construct(private string $value) {
		if ($value === '') {
			throw new InvalidPasswordHashException($value);
		}
	}

	public function getValue(): string {
		return $this->value;
	}
}
