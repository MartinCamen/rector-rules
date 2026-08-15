<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Rector;

final class SingleLineDocBlockMaxLineLengthRectorTest extends AbstractRectorRuleTestCase
{
    protected static function fixtureDirectory(): string
    {
        return __DIR__ . '/../Fixture/SingleLineDocBlockMaxLineLength';
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/../config/max_line_length.php';
    }
}
