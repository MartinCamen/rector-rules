<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

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
