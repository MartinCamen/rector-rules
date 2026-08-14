<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\FixtureMergeThrows;

class ExistingUnions
{
    /**
     * @throws SecondException|FirstException
     */
    public function sortsOnItsOwn(): void
    {
    }

    /**
     * @throws SecondException|FirstException
     * @throws SecondException
     * @throws ThirdException
     */
    public function mergesAndDeduplicates(): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\FixtureMergeThrows;

class ExistingUnions
{
    /**
     * @throws FirstException|SecondException
     */
    public function sortsOnItsOwn(): void
    {
    }

    /**
     * @throws FirstException|SecondException|ThirdException
     */
    public function mergesAndDeduplicates(): void
    {
    }
}

?>
