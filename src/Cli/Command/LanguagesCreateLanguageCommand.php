<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Cli\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
	name: 'languages:create-language',
	description: 'Create a language',
)]
class LanguagesCreateLanguageCommand {
	public function __invoke(
		SymfonyStyle $io,
		#[Argument('Language Code')]
		string $code,
		#[Argument('English Name')]
		string $englishName,
		#[Argument('Native Name')]
		string $nativeName,
		#[Option('Fallback', 'fallback', 'f')]
		bool $fallback = false,
	): int {
		$io->note(sprintf('The value of $code is: %s', var_export($code, true)));
		$io->note(sprintf('The value of $englishName is: %s', var_export($englishName, true)));
		$io->note(sprintf('The value of $nativeName is: %s', var_export($nativeName, true)));
		$io->note(sprintf('The value of $fallback is: %s', var_export($fallback, true)));

		$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

		return Command::SUCCESS;
	}
}
