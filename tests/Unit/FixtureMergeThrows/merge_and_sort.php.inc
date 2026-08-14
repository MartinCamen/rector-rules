<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\FixtureMergeThrows;

class MergeAndSort
{
    /**
     * @throws \RuntimeException
     * @throws \DomainException
     * @throws \LogicException
     */
    public function handle(): void
    {
    }

    /**
     * Sends the order confirmation.
     *
     * @param array<int, string> $names
     * @throws \RuntimeException
     * @throws \DomainException
     */
    public function confirm(array $names): void
    {
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\FixtureMergeThrows;

class MergeAndSort
{
    /**
     * @throws \DomainException|\LogicException|\RuntimeException
     */
    public function handle(): void
    {
    }

    /**
     * Sends the order confirmation.
     *
     * @param array<int, string> $names
     * @throws \DomainException|\RuntimeException
     */
    public function confirm(array $names): void
    {
    }
}

?>
