<?php

/**
 * @author Nikita Prokopenko <radynje@gmail.com>
 */

declare(strict_types = 1);

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\ParserFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$arguments = $_SERVER['argv'] ?? [];
if (count($arguments) !== 2 || !is_file($arguments[1])) {
	fwrite(STDERR, "Usage: php bin/generate-getters.php <php-file>\n");
	exit(1);
}

$file = $arguments[1];
$source = file_get_contents($file);
if ($source === false) {
	fwrite(STDERR, "Cannot read {$file}\n");
	exit(1);
}

try {
	$statements = (new ParserFactory())->createForHostVersion()->parse($source);
} catch (Throwable $exception) {
	fwrite(STDERR, $exception->getMessage() . "\n");
	exit(1);
}

$classes = [];
foreach ($statements ?? [] as $statement) {
	$namespaceStatements = $statement instanceof Node\Stmt\Namespace_ ? $statement->stmts : [$statement];
	foreach ($namespaceStatements as $namespaceStatement) {
		if ($namespaceStatement instanceof Class_ && $namespaceStatement->name !== null) {
			$classes[] = $namespaceStatement;
		}
	}
}

if (count($classes) !== 1) {
	fwrite(STDERR, "Expected exactly one named class in {$file}\n");
	exit(1);
}

$class = $classes[0];
$properties = [];
$existingMethods = [];

foreach ($class->stmts as $statement) {
	if ($statement instanceof Property && !$statement->isStatic()) {
		foreach ($statement->props as $property) {
			$properties[$property->name->toString()] = $statement->type;
		}
	}

	if (!$statement instanceof ClassMethod) {
		continue;
	}

	$existingMethods[strtolower($statement->name->toString())] = true;
	if (strtolower($statement->name->toString()) !== '__construct') {
		continue;
	}

	foreach ($statement->params as $parameter) {
		if ($parameter->isPromoted() && $parameter->var instanceof Variable && is_string($parameter->var->name)) {
			$properties[$parameter->var->name] = $parameter->type;
		}
	}
}

$eol = str_contains($source, "\r\n") ? "\r\n" : "\n";
$indent = preg_match('/\R([ \t]+)(?:public|protected|private|readonly|#\[)/', $source, $matches) ? $matches[1] : "\t";
$methods = [];

foreach ($properties as $name => $type) {
	$boolean = $type instanceof Node\Identifier && strtolower($type->toString()) === 'bool';
	$method = $boolean
		? (preg_match('/^is[A-Z]/', $name) ? $name : 'is' . ucfirst($name))
		: 'get' . ucfirst($name);

	if (isset($existingMethods[strtolower($method)])) {
		continue;
	}

	$returnType = $type === null ? '' : ': ' . substr($source, $type->getStartFilePos(), $type->getEndFilePos() - $type->getStartFilePos() + 1);
	$methods[] = $indent . "public function {$method}(){$returnType} {" . $eol
		. $indent . $indent . 'return $this->' . $name . ';' . $eol
		. $indent . '}';
	$existingMethods[strtolower($method)] = true;
}

if ($methods === []) {
	echo "No getters to add.\n";
	exit(0);
}

$close = $class->getEndFilePos();
$before = rtrim(substr($source, 0, $close), " \t\r\n");
$separator = $class->stmts === [] ? $eol : $eol . $eol;
$updated = $before . $separator . implode($eol . $eol, $methods) . $eol . substr($source, $close);
if (file_put_contents($file, $updated) === false) {
	fwrite(STDERR, "Cannot write {$file}\n");
	exit(1);
}

echo 'Added ' . count($methods) . ' getter(s).' . "\n";
