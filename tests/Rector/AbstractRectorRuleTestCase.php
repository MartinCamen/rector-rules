<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Rector;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

abstract class AbstractRectorRuleTestCase extends AbstractRectorTestCase
{
    #[Test]
    #[DataProvider('fixtureFilePathProvider')]
    public function transformsFixture(string $fixtureFilePath): void
    {
        $this->doTestFile($fixtureFilePath);
    }

    public static function fixtureFilePathProvider(): Iterator
    {
        return self::yieldFilesFromDirectory(static::fixtureDirectory());
    }

    abstract protected static function fixtureDirectory(): string;
}
