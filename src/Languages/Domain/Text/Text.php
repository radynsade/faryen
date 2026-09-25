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
		private TextId $id,
		private array $translations,
	) {
	}

	public function getId(): TextId {
		return $this->id;
	}

	/**
	 * @return Translation[]
	 */
	public function getTranslations(): array {
		return $this->translations;
	}
}
