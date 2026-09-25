<?php

namespace App\Languages\Domain\Text;

interface Repository {
	public function create(Text $text): void;

	public function delete(Text $text): void;
}
