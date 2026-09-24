<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Domain\Text;

class Text {
	/**
	 * @param Translation[] $translations
	 */
	public function __construct(
		private array $translations,
	) {
	}
}
