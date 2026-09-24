<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Security\Domain;

use App\Security\Exception\InvalidPhoneNumberException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber {
	private string $value;

	public function __construct(string $value) {
		$util = PhoneNumberUtil::getInstance();
		$isValid = false;
		$previousException = null;

		try {
			$number = $util->parse($value);

			if ($util->isValidNumber($number)) {
				$isValid = true;
				$this->value = $util->format($number, PhoneNumberFormat::E164);
			}
		} catch (NumberParseException $exception) {
			$previousException = $exception;
		}

		if (!$isValid) {
			throw new InvalidPhoneNumberException(
				$value,
				$previousException?->getCode() ?: 0,
				$previousException,
			);
		}
	}

	public function getValue(): string {
		return $this->value;
	}
}
