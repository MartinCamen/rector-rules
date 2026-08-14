<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\Fixture;

class SurroundingCommentsAndAttributes
{
    // Runs on every dispatch.
    /**
     * @throws \Throwable
     */
    #[\Override]
    public function handle(): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\Fixture;

class SurroundingCommentsAndAttributes
{
    // Runs on every dispatch.
    /** @throws \Throwable */
    #[\Override]
    public function handle(): void
    {
    }
}

?>
