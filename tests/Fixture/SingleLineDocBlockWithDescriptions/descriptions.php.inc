<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlockWithDescriptions;

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

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlockWithDescriptions;

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
