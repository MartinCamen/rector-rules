<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Rector;

final class SingleLineDocBlockWithDescriptionsRectorTest extends AbstractRectorRuleTestCase
{
    protected static function fixtureDirectory(): string
    {
        return __DIR__ . '/../Fixture/SingleLineDocBlockWithDescriptions';
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/../config/collapse_descriptions.php';
    }
}
