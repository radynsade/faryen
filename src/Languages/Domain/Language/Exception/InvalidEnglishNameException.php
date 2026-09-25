<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Language\Exception;

use InvalidArgumentException;
use Throwable;

class InvalidEnglishNameException extends InvalidArgumentException {
	public function __construct(
		private string $value,
		int $code = 0,
		?Throwable $previous = null,
	) {
		$message = "\"{$value}\" is not a valid language english name.";
		parent::__construct($message, $code, $previous);
	}

	public function getValue(): string {
		return $this->value;
	}
}
