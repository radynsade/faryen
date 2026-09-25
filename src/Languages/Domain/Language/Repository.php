<?php

namespace App\Languages\Domain\Language;

interface Repository {
	public function existsByCode(Code $code): bool;

	public function create(Language $language): void;

	public function delete(Language $language): void;
}
