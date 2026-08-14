<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\Fixture;

class SkipDescriptions
{
    /**
     * Handles the job.
     */
    public function handle(): void
    {
    }

    /** @throws \Throwable */
    public function alreadyOnOneLine(): void
    {
    }

    // Not a doc block.
    public function withoutDocBlock(): void
    {
    }
}
