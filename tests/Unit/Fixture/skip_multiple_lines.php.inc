<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\Fixture;

class SkipMultipleLines
{
    /**
     * @param array<int, string> $names
     *
     * @throws \Throwable
     */
    public function handle(array $names): void
    {
    }

    /**
     * Sends the order confirmation.
     *
     * @throws \Throwable
     */
    public function confirm(): void
    {
    }
}
