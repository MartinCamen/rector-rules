<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlockMaxLineLength;

class CollapseWithinConfiguredLimit
{
    /**
     * @throws Throwable
     */
    public function handle(): void
    {
    }
}

?>
-----
<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlockMaxLineLength;

class CollapseWithinConfiguredLimit
{
    /** @throws Throwable */
    public function handle(): void
    {
    }
}

?>
