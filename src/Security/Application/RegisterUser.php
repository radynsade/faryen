<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Security\Application;

class RegisterUser {
	public function __invoke(
		string $email,
		string $phone,
		string $firstName,
		string $lastName,
	): void {
	}
}
