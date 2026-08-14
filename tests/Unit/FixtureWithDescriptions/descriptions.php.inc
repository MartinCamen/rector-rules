<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\FixtureWithDescriptions;

class Descriptions
{
    /**
     * Handles the job.
     */
    public function handle(): void
    {
    }

    /**
     * @throws \Throwable
     */
    public function confirm(): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\FixtureWithDescriptions;

class Descriptions
{
    /** Handles the job. */
    public function handle(): void
    {
    }

    /** @throws \Throwable */
    public function confirm(): void
    {
    }
}

?>
