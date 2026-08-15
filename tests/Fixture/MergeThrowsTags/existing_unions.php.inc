<?php

namespace MartinCamen\RectorRules\Tests\Fixture\MergeThrowsTags;

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

namespace MartinCamen\RectorRules\Tests\Fixture\MergeThrowsTags;

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
