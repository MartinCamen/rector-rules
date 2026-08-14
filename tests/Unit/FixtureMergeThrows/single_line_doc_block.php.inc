<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\FixtureMergeThrows;

class SingleLineDocBlock
{
    /** @throws SecondException|FirstException */
    public function sortsTypes(): void
    {
    }

    /** @throws FirstException */
    public function leftAsItIs(): void
    {
    }

    /** @throws FirstException when the order is already paid */
    public function withDescription(): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\FixtureMergeThrows;

class SingleLineDocBlock
{
    /** @throws FirstException|SecondException */
    public function sortsTypes(): void
    {
    }

    /** @throws FirstException */
    public function leftAsItIs(): void
    {
    }

    /** @throws FirstException when the order is already paid */
    public function withDescription(): void
    {
    }
}

?>
