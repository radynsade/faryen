<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Text;

class TextId {
	public function __construct(private string $value) {
	}

	public function getValue(): string {
		return $this->value;
	}
}
