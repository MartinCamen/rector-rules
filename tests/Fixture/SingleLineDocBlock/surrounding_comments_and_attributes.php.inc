<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

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

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

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
