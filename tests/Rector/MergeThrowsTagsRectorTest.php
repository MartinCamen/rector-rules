<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Rector;

final class MergeThrowsTagsRectorTest extends AbstractRectorRuleTestCase
{
    protected static function fixtureDirectory(): string
    {
        return __DIR__ . '/../Fixture/MergeThrowsTags';
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/../config/merge_throws_tags.php';
    }
}
