<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Security\Domain;

class User {
	public function __construct(
		private EmailAddress $email,
		private PhoneNumber $phone,
		private PasswordHash $passwordHash,
		private string $firstName,
		private string $lastName,
	) {
	}

	public function getEmail(): EmailAddress {
		return $this->email;
	}

	public function getPhone(): PhoneNumber {
		return $this->phone;
	}

	public function getPasswordHash(): PasswordHash {
		return $this->passwordHash;
	}

	public function getFirstName(): string {
		return $this->firstName;
	}

	public function getLastName(): string {
		return $this->lastName;
	}
}
