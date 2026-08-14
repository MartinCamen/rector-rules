<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\FixtureMergeThrows;

class SortsOnShortName
{
    /**
     * @throws \Zebra\FirstException
     * @throws \Apple\SecondException
     */
    public function handle(): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\FixtureMergeThrows;

class SortsOnShortName
{
    /**
     * @throws \Zebra\FirstException|\Apple\SecondException
     */
    public function handle(): void
    {
    }
}

?>
