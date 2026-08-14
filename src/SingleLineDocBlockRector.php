<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules;

use Rector\Contract\Rector\ConfigurableRectorInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

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

    private bool $collapseDescriptions = false;
    private int $maxLineLength = 120;

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
                        self::COLLAPSE_DESCRIPTIONS => false,
                        self::MAX_LINE_LENGTH       => 120,
                    ],
                ),
            ],
        );
    }

    /** @param array<string, bool|int> $configuration */
    public function configure(array $configuration): void
    {
        $collapseDescriptions = $configuration[self::COLLAPSE_DESCRIPTIONS] ?? false;
        Assert::boolean($collapseDescriptions);

        $maxLineLength = $configuration[self::MAX_LINE_LENGTH] ?? 120;
        Assert::natural($maxLineLength);

        $this->collapseDescriptions = $collapseDescriptions;
        $this->maxLineLength = $maxLineLength;
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
