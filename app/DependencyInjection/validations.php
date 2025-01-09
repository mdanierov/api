<?php

use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\Finder\Finder;

$finder = new Finder();

// Suche nach .php-Dateien
$finder->files()->in(dirname(__DIR__) . '/Validations/')->name('*.php');
$validations = [];

foreach ($finder as $file) {
    $className =
        'DMirzorasul\\Api\\Validations\\' . str_replace('/', '\\', substr($file->getRelativePathname(), 0, -4));

    if (!class_exists($className)) {
        continue;
    }

    // ReflectionClass für die Klasse
    $reflection       = new ReflectionClass($className);
    $parentReflection = $reflection->getParentClass();

    if (!$parentReflection || $parentReflection->getName() !== AbstractValidator::class) {
        continue;
    }

    $validations[$className] = function () use ($className) {
        /** @var AbstractValidator $validator */
        $validator = $className::createFromGlobals();

        $violations = $validator->validate();

        return $validator;
    };
}

return $validations;