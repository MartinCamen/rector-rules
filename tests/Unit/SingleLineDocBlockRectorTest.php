<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Unit\Rector;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class SingleLineDocBlockRectorTest extends AbstractRectorTestCase
{
    #[Test]
    #[DataProvider('fixtureDataProvider')]
    public function collapsesSingleLineDocBlocks(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function fixtureDataProvider(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
