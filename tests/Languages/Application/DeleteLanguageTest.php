<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Tests\Languages\Application;

use App\Languages\Application\DeleteLanguage;
use App\Languages\Domain\Language\Code;
use App\Languages\Domain\Language\EnglishName;
use App\Languages\Domain\Language\Event\LanguageDeletedEvent;
use App\Languages\Domain\Language\Exception\LanguageNotFoundException;
use App\Languages\Domain\Language\Language;
use App\Languages\Domain\Language\NativeName;
use App\Languages\Domain\Language\Repository;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Clock\ClockInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[CoversClass(DeleteLanguage::class)]
final class DeleteLanguageTest extends KernelTestCase {
	public function testDeletesLanguageAndDispatchesEvent(): void {
		$language = new Language(new Code('en'), new NativeName('English'), new EnglishName('English'), false);
		$occurredAt = new DateTimeImmutable('2026-09-25T12:00:00+00:00');
		$repository = $this->createMock(Repository::class);
		$repository->expects(self::once())->method('delete')->with($language);
		$clock = $this->createMock(ClockInterface::class);
		$clock->expects(self::once())->method('now')->willReturn($occurredAt);
		$dispatcher = $this->createMock(EventDispatcherInterface::class);
		$dispatcher->expects(self::once())->method('dispatch')->with(self::callback(
			static function (object $event) use ($language, $occurredAt): bool {
				return $event instanceof LanguageDeletedEvent
					&& $event->getLanguage() === $language
					&& $event->getOccurredAt() === $occurredAt;
			},
		));

		(new DeleteLanguage($repository, $dispatcher, $clock))($language);
	}

	public function testDoesNotDispatchWhenDeletionFails(): void {
		$language = new Language(new Code('en'), new NativeName('English'), new EnglishName('English'), false);
		$repository = $this->createMock(Repository::class);
		$repository->expects(self::once())->method('delete')->with($language)->willThrowException(new LanguageNotFoundException($language->getCode()));
		$dispatcher = $this->createMock(EventDispatcherInterface::class);
		$dispatcher->expects(self::never())->method('dispatch');
		$clock = $this->createMock(ClockInterface::class);
		$clock->expects(self::never())->method('now');

		$this->expectException(LanguageNotFoundException::class);
		(new DeleteLanguage($repository, $dispatcher, $clock))($language);
	}
}
