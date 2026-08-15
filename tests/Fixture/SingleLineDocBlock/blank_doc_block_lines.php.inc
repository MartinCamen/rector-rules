<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

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

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

class BlankDocBlockLines
{
    /** @throws \Throwable */
    public function handle(): void
    {
    }
}

?>
