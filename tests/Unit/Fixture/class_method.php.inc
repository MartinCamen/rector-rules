<?php

namespace MartinCamen\RectorRules\Tests\Unit\Rector\Fixture;

class ClassMethodDocBlock
{
    /**
     * @throws \Throwable
     */
    public function handle(): void
    {
        $this->doSomething([
            'key' => 'value',
        ]);
    }
}

?>
-----
<?php

namespace Tests\Unit\Rector\Fixture;

class ClassMethodDocBlock
{
    /** @throws \Throwable */
    public function handle(): void
    {
        $this->doSomething([
            'key' => 'value',
        ]);
    }
}

?>
