<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Tests\Tools;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

final class GenerateGettersTest extends TestCase {
	public function testGeneratesMissingGettersForPromotedAndDeclaredProperties(): void {
		$file = tempnam(sys_get_temp_dir(), 'getters-');
		self::assertNotFalse($file);

		try {
			file_put_contents($file, <<<'EOD'
<?php

class Example {
	private ?\DateTimeImmutable $createdAt = null;

	public function __construct(
		private string $name,
		private bool $isFallback,
	) {
	}

	public function getName(): string {
		return $this->name;
	}
}
EOD);

			$command = [PHP_BINARY, dirname(__DIR__, 2) . '/bin/generate-getters.php', $file];
			$firstRun = new Process($command);
			$firstRun->run();
			self::assertTrue($firstRun->isSuccessful(), $firstRun->getErrorOutput());
			self::assertSame("Added 2 getter(s).\n", $firstRun->getOutput());

			$generated = file_get_contents($file);
			self::assertIsString($generated);
			self::assertStringContainsString('public function getCreatedAt(): ?\DateTimeImmutable', $generated);
			self::assertStringContainsString('public function isFallback(): bool', $generated);
			self::assertSame(1, substr_count($generated, 'function getName('));

			$lint = new Process([PHP_BINARY, '-l', $file]);
			$lint->run();
			self::assertTrue($lint->isSuccessful(), $lint->getErrorOutput());

			$secondRun = new Process($command);
			$secondRun->run();
			self::assertTrue($secondRun->isSuccessful(), $secondRun->getErrorOutput());
			self::assertSame("No getters to add.\n", $secondRun->getOutput());
			self::assertSame($generated, file_get_contents($file));
		} finally {
			unlink($file);
		}
	}
}
