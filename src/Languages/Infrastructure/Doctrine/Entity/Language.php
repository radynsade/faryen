<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Languages\Infrastructure\Doctrine\Entity;

use App\Languages\Infrastructure\Doctrine\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 2)]
	private ?string $code = null;

	#[ORM\Column(length: 50)]
	private ?string $englishName = null;

	#[ORM\Column(length: 50)]
	private ?string $nativeName = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function getCode(): ?string {
		return $this->code;
	}

	public function setCode(string $code): static {
		$this->code = $code;
		return $this;
	}

	public function getEnglishName(): ?string {
		return $this->englishName;
	}

	public function setEnglishName(string $englishName): static {
		$this->englishName = $englishName;
		return $this;
	}

	public function getNativeName(): ?string {
		return $this->nativeName;
	}

	public function setNativeName(string $nativeName): static {
		$this->nativeName = $nativeName;
		return $this;
	}
}
