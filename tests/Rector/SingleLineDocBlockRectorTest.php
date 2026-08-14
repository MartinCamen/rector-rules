<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Rector;

final class SingleLineDocBlockRectorTest extends AbstractRectorRuleTestCase
{
    protected static function fixtureDirectory(): string
    {
        return __DIR__ . '/../Fixture/SingleLineDocBlock';
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/../config/single_line_doc_block.php';
    }
}
