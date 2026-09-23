<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

namespace App\Landing\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class IndexController {
	#[Route('/', methods: ['GET'])]
	public function __invoke(): Response {
		return new Response('Hello, Bobby!');
	}
}
