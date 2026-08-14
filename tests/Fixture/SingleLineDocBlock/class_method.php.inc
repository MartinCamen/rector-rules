<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

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

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

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
