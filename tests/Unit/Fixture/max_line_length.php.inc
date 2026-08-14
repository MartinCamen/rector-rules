<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\Fixture;

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

namespace Tests\Unit\Rector\Fixture;

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
