<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/database',
        __DIR__ . '/tests',
        __DIR__ . '/ecs.php',
    ]);

    $containerConfigurator->import(SetList::ARRAY);
    $containerConfigurator->import(SetList::STRICT);
    $containerConfigurator->import(SetList::SPACES);
    $containerConfigurator->import(SetList::NAMESPACES);
    $containerConfigurator->import(SetList::CONTROL_STRUCTURES);
    $containerConfigurator->import(SetList::DOCBLOCK);
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::CLEAN_CODE);

    $services = $containerConfigurator->services();
    $services->set(FinalClassFixer::class);
    $services->set(VoidReturnFixer::class);
    $services->set(DeclareStrictTypesFixer::class);
    $services->set(OrderedImportsFixer::class)
        ->call('configure', [[
            'sort_algorithm' => 'length',
        ]]);
    $services->set(PhpUnitMethodCasingFixer::class)
        ->call('configure', [[
            'case' => 'snake_case',
        ]]);
};
