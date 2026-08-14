<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules;

use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * Merges the @throws tags of a doc block into a single alphabetically sorted union tag.
 */
final class MergeThrowsTagsRector extends AbstractDocBlockRector
{
    /**
     * Matches a @throws tag carrying nothing but a type expression, so tags with a description are left alone.
     *
     * @see https://regex101.com/r/nT2Dcp/1
     */
    private const string THROWS_TAG_REGEX = '#^(?<prefix>\s*\*\s*)@throws\s+(?<types>[\\\\\w|]+)\s*$#';

    /**
     * Matches a doc block already holding nothing but a @throws tag on one line.
     *
     * @see https://regex101.com/r/hK3Vbs/1
     */
    private const string SINGLE_LINE_THROWS_DOC_BLOCK_REGEX = '#^/\*\*\s+@throws\s+(?<types>[\\\\\w|]+)\s*\*/$#';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Merge the @throws tags of a doc block into a single alphabetically sorted union tag',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
                        class SomeClass
                        {
                            /**
                             * @throws SecondException
                             * @throws FirstException
                             */
                            public function handle(): void
                            {
                            }
                        }
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        class SomeClass
                        {
                            /**
                             * @throws FirstException|SecondException
                             */
                            public function handle(): void
                            {
                            }
                        }
                        CODE_SAMPLE,
                ),
            ],
        );
    }

    protected function refactorDocBlock(string $docBlock): ?string
    {
        $lines = $this->splitIntoLines($docBlock);

        if ($lines === null) {
            return $this->sortSingleLineDocBlock($docBlock);
        }

        $throwsLineNumbers = $this->resolveThrowsLineNumbers($lines);

        if ($throwsLineNumbers === []) {
            return null;
        }

        $types = $this->resolveThrownTypes($lines, $throwsLineNumbers);

        if ($types === null) {
            return null;
        }

        $firstThrowsLineNumber = $throwsLineNumbers[0];
        preg_match(self::THROWS_TAG_REGEX, $lines[$firstThrowsLineNumber], $matches);

        array_splice($lines, $firstThrowsLineNumber, count($throwsLineNumbers), [
            $matches['prefix'] . '@throws ' . implode('|', $types),
        ]);

        return implode(str_contains($docBlock, "\r\n") ? "\r\n" : "\n", $lines);
    }

    /**
     * Sorts the types of a doc block that already holds its @throws tag on a single line.
     */
    private function sortSingleLineDocBlock(string $docBlock): ?string
    {
        if (preg_match(self::SINGLE_LINE_THROWS_DOC_BLOCK_REGEX, $docBlock, $matches) !== 1) {
            return null;
        }

        $types = $this->sortTypes(explode('|', $matches['types']));

        return $types === null ? null : '/** @throws ' . implode('|', $types) . ' */';
    }

    /**
     * Returns the line numbers holding a @throws tag, or none when they are not written as one block. Merging tags
     * that are spread over the doc block would leave the lines in between stranded.
     *
     * @param array<int, string> $lines
     * @return array<int, int>
     */
    private function resolveThrowsLineNumbers(array $lines): array
    {
        $throwsLineNumbers = [];

        foreach ($lines as $lineNumber => $line) {
            if (preg_match('#^\s*\*\s*@throws\b#', $line) === 1) {
                $throwsLineNumbers[] = $lineNumber;
            }
        }

        if ($throwsLineNumbers === []) {
            return [];
        }

        $span = $throwsLineNumbers[count($throwsLineNumbers) - 1] - $throwsLineNumbers[0] + 1;

        return $span === count($throwsLineNumbers) ? $throwsLineNumbers : [];
    }

    /**
     * Returns the thrown types, sorted and without duplicates, or null when a tag carries more than a type.
     *
     * @param array<int, string> $lines
     * @param array<int, int> $throwsLineNumbers
     * @return array<int, string>|null
     */
    private function resolveThrownTypes(array $lines, array $throwsLineNumbers): ?array
    {
        $types = [];

        foreach ($throwsLineNumbers as $lineNumber) {
            if (preg_match(self::THROWS_TAG_REGEX, $lines[$lineNumber], $matches) !== 1) {
                return null;
            }

            $types = [...$types, ...explode('|', $matches['types'])];
        }

        return $this->sortTypes($types);
    }

    /**
     * Sorts thrown types alphabetically and drops duplicates, or returns null when one of them is empty.
     *
     * Sorting on the short class name keeps the order stable once Rector imports the names, which it does after
     * this rule has run.
     *
     * @param array<int, string> $types
     * @return array<int, string>|null
     */
    private function sortTypes(array $types): ?array
    {
        if (in_array('', $types, true)) {
            return null;
        }

        $types = array_values(array_unique($types));

        usort($types, static function (string $first, string $second): int {
            $shortNameOrder = strcasecmp(self::resolveShortName($first), self::resolveShortName($second));

            return $shortNameOrder === 0 ? strcasecmp($first, $second) : $shortNameOrder;
        });

        return $types;
    }

    private static function resolveShortName(string $type): string
    {
        $separatorPosition = strrpos($type, '\\');

        return $separatorPosition === false ? $type : substr($type, $separatorPosition + 1);
    }
}
