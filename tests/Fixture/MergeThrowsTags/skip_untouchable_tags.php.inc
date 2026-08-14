<?php

namespace MartinCamen\RectorRules\Tests\Fixture\MergeThrowsTags;

class SkipUntouchableTags
{
    /**
     * @throws FirstException when the order is already paid
     * @throws SecondException
     */
    public function withDescription(): void
    {
    }

    /**
     * @throws FirstException
     *
     * @throws SecondException
     */
    public function separatedByABlankLine(): void
    {
    }

    /**
     * @throws FirstException
     * @param int $attempts
     * @throws SecondException
     */
    public function separatedByAnotherTag(int $attempts): void
    {
    }

    /**
     * @throws SingleException
     */
    public function leftAsItIs(): void
    {
    }

    /** @throws FirstException|SecondException */
    public function alreadyMerged(): void
    {
    }
}
