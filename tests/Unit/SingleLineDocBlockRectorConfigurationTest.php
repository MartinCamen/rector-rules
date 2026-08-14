<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules\Tests\Unit;

use MartinCamen\RectorRules\SingleLineDocBlockRector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Rector\Exception\Configuration\InvalidConfigurationException;

final class SingleLineDocBlockRectorConfigurationTest extends TestCase
{
    #[Test]
    public function rejectsNonBooleanCollapseDescriptions(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->configure([SingleLineDocBlockRector::COLLAPSE_DESCRIPTIONS => 'yes']);
    }

    #[Test]
    public function rejectsNonIntegerMaxLineLength(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->configure([SingleLineDocBlockRector::MAX_LINE_LENGTH => '120']);
    }

    #[Test]
    public function rejectsNegativeMaxLineLength(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->configure([SingleLineDocBlockRector::MAX_LINE_LENGTH => -1]);
    }

    #[Test]
    public function rejectsUnknownOption(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->configure(['collapse_description' => true]);
    }

    #[Test]
    public function namesTheUnknownOptionItRejects(): void
    {
        $this->expectExceptionMessageMatches('#collapse_description#');

        $this->configure(['collapse_description' => true]);
    }

    #[Test]
    public function acceptsAnEmptyConfiguration(): void
    {
        $this->expectNotToPerformAssertions();

        $this->configure([]);
    }

    /** @param array<string, mixed> $configuration */
    private function configure(array $configuration): void
    {
        // @phpstan-ignore argument.type
        (new SingleLineDocBlockRector())->configure($configuration);
    }
}
