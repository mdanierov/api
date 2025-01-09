<?php

use DI\Container;
use DMirzorasul\Api\Validations\AbstractValidator;
use Symfony\Component\Finder\Finder;

$finder = new Finder();

/**
 * TODO: Use service
 * TODO: Use const
 */
$finder->files()->in(dirname(__DIR__) . '/Validations/')->name('*.php');
$validations = [];

foreach ($finder as $file) {
    /**
     * TODO: Use service
     * TODO: Use const
     */
    $className =
        'DMirzorasul\\Api\\Validations\\' . str_replace('/', '\\', substr($file->getRelativePathname(), 0, -4));

    if (!class_exists($className)) {
        continue;
    }

    $reflection       = new ReflectionClass($className);
    $parentReflection = $reflection->getParentClass();
    if (!$parentReflection || $parentReflection->getName() !== AbstractValidator::class) {
        continue;
    }

    $validations[$className] = function (Container $container) use ($className) {
        try {
            /** @var AbstractValidator $validator */
            $validator = $container->call([ $className, 'createFromGlobals' ]);
            $container->call([ $validator, 'validate' ]);

            return $validator;
        } catch (Exception $exception) {
            // TODO: ADD Exception.
            throw $exception;
        }
    };
}

return $validations;