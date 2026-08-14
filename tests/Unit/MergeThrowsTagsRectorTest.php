<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Unit\Rector;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class MergeThrowsTagsRectorTest extends AbstractRectorTestCase
{
    #[Test]
    #[DataProvider('fixtureDataProvider')]
    public function mergesThrowsTags(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function fixtureDataProvider(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/FixtureMergeThrows');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/merge_throws_tags.php';
    }
}
