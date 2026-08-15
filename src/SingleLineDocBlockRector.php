<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules;

use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Exception\Configuration\InvalidConfigurationException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Collapses a doc block that holds a single line of content onto one line.
 */
final class SingleLineDocBlockRector extends AbstractDocBlockRector implements ConfigurableRectorInterface
{
    /**
     * Also collapse doc blocks holding a plain description instead of an annotation.
     */
    public const string COLLAPSE_DESCRIPTIONS = 'collapse_descriptions';

    /**
     * Leave doc blocks alone when collapsing them would make the line longer than this. Use 0 for no limit.
     */
    public const string MAX_LINE_LENGTH = 'max_line_length';

    private const bool DEFAULT_COLLAPSE_DESCRIPTIONS = false;
    private const int DEFAULT_MAX_LINE_LENGTH = 120;

    private bool $collapseDescriptions = self::DEFAULT_COLLAPSE_DESCRIPTIONS;
    private int $maxLineLength = self::DEFAULT_MAX_LINE_LENGTH;

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Collapse a doc block with a single line of content onto one line',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
                        class SomeClass
                        {
                            /**
                             * @throws Throwable
                             */
                            public function handle(): void
                            {
                            }
                        }
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        class SomeClass
                        {
                            /** @throws Throwable */
                            public function handle(): void
                            {
                            }
                        }
                        CODE_SAMPLE,
                    [
                        self::COLLAPSE_DESCRIPTIONS => self::DEFAULT_COLLAPSE_DESCRIPTIONS,
                        self::MAX_LINE_LENGTH       => self::DEFAULT_MAX_LINE_LENGTH,
                    ],
                ),
            ],
        );
    }

    /** @param array<string, mixed> $configuration */
    public function configure(array $configuration): void
    {
        $this->guardAgainstUnknownOptions($configuration);

        $this->collapseDescriptions = $this->resolveCollapseDescriptions($configuration);
        $this->maxLineLength = $this->resolveMaxLineLength($configuration);
    }

    /** @param array<string, mixed> $configuration */
    private function guardAgainstUnknownOptions(array $configuration): void
    {
        $unknownOptions = array_diff(
            array_keys($configuration),
            [self::COLLAPSE_DESCRIPTIONS, self::MAX_LINE_LENGTH],
        );

        if ($unknownOptions === []) {
            return;
        }

        throw new InvalidConfigurationException(sprintf(
            'Unknown option(s) "%s" given to %s. Expected any of "%s".',
            implode('", "', $unknownOptions),
            self::class,
            implode('", "', [self::COLLAPSE_DESCRIPTIONS, self::MAX_LINE_LENGTH]),
        ));
    }

    /** @param array<string, mixed> $configuration */
    private function resolveCollapseDescriptions(array $configuration): bool
    {
        $collapseDescriptions = $configuration[self::COLLAPSE_DESCRIPTIONS] ?? self::DEFAULT_COLLAPSE_DESCRIPTIONS;

        if (! is_bool($collapseDescriptions)) {
            throw new InvalidConfigurationException(sprintf(
                'Option "%s" expects a bool, %s given.',
                self::COLLAPSE_DESCRIPTIONS,
                get_debug_type($collapseDescriptions),
            ));
        }

        return $collapseDescriptions;
    }

    /** @param array<string, mixed> $configuration */
    private function resolveMaxLineLength(array $configuration): int
    {
        $maxLineLength = $configuration[self::MAX_LINE_LENGTH] ?? self::DEFAULT_MAX_LINE_LENGTH;

        if (! is_int($maxLineLength)) {
            throw new InvalidConfigurationException(sprintf(
                'Option "%s" expects an int, %s given.',
                self::MAX_LINE_LENGTH,
                get_debug_type($maxLineLength),
            ));
        }

        if ($maxLineLength < 0) {
            throw new InvalidConfigurationException(sprintf(
                'Option "%s" expects a non-negative int, %d given.',
                self::MAX_LINE_LENGTH,
                $maxLineLength,
            ));
        }

        return $maxLineLength;
    }

    protected function refactorDocBlock(string $docBlock): ?string
    {
        $lines = $this->splitIntoLines($docBlock);

        if ($lines === null) {
            return null;
        }

        $content = $this->resolveSingleContentLine($lines);

        if ($content === null) {
            return null;
        }

        if (! $this->collapseDescriptions && ! str_starts_with($content, '@')) {
            return null;
        }

        $singleLineDocBlock = '/** ' . $content . ' */';

        if ($this->isTooLong($singleLineDocBlock, $lines[count($lines) - 1])) {
            return null;
        }

        return $singleLineDocBlock;
    }

    /**
     * The closing line carries the indentation of the doc block, one space wider than the code it documents.
     */
    private function isTooLong(string $singleLineDocBlock, string $closingLine): bool
    {
        if ($this->maxLineLength === 0) {
            return false;
        }

        $indentation = max(0, mb_strlen($closingLine) - mb_strlen(ltrim($closingLine)) - 1);

        return $indentation + mb_strlen($singleLineDocBlock) > $this->maxLineLength;
    }

    /**
     * Returns the only line of content in the doc block, or null when it holds none or several.
     *
     * @param array<int, string> $lines
     */
    private function resolveSingleContentLine(array $lines): ?string
    {
        array_shift($lines);
        array_pop($lines);

        $contents = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if (! str_starts_with($line, '*')) {
                return null;
            }

            $content = trim(substr($line, 1));

            if ($content === '') {
                continue;
            }

            $contents[] = $content;
        }

        if (count($contents) !== 1) {
            return null;
        }

        return $contents[0];
    }
}
