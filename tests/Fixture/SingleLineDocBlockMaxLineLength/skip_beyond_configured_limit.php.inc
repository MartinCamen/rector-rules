<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlockMaxLineLength;

class SkipBeyondConfiguredLimit
{
    /**
     * @throws VeryLongNamespace\ThatKeepsGoing\SomeLongException
     */
    public function handle(): void
    {
    }
}
