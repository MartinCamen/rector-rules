<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\Fixture;

class BlankDocBlockLines
{
    /**
     *
     * @throws \Throwable
     *
     */
    public function handle(): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\Fixture;

class BlankDocBlockLines
{
    /** @throws \Throwable */
    public function handle(): void
    {
    }
}

?>
