<?php

namespace MartinCamen\RectorRules\Tests\Fixture\MergeThrowsTags;

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

namespace MartinCamen\RectorRules\Tests\Fixture\MergeThrowsTags;

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
