<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

class MaxLineLength
{
    /**
     * @param array<int, array{ETag: string, 'Duplicate Count': int, 'File Key': string, 'Size (bytes)': int}> $rows
     */
    public function fitsOnOneLine(array $rows): void
    {
    }

    /**
     * @param array<int, array{ETag: string, 'Duplicate Count': int, 'File Key': string, 'Size (bytes)': int, 'Last Modified': string}> $rows
     */
    public function tooLongForOneLine(array $rows): void
    {
    }
}

?>
-----
<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

class MaxLineLength
{
    /** @param array<int, array{ETag: string, 'Duplicate Count': int, 'File Key': string, 'Size (bytes)': int}> $rows */
    public function fitsOnOneLine(array $rows): void
    {
    }

    /**
     * @param array<int, array{ETag: string, 'Duplicate Count': int, 'File Key': string, 'Size (bytes)': int, 'Last Modified': string}> $rows
     */
    public function tooLongForOneLine(array $rows): void
    {
    }
}

?>
