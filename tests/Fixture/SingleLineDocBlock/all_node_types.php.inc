<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AllNodeTypes
{
    /**
     * @var array<int, string>
     */
    public const array NAMES = ['first'];

    /**
     * @var array<int, string>
     */
    private array $names = [];

    /**
     * @return array<int, string>
     */
    public function names(): array
    {
        return $this->names;
    }
}

/**
 * @deprecated
 */
interface AllNodeTypesContract
{
}

/**
 * @deprecated
 */
trait AllNodeTypesTrait
{
}

/**
 * @deprecated
 */
enum AllNodeTypesEnum: string
{
    /**
     * @deprecated
     */
    case First = 'first';
}

/**
 * @throws \Throwable
 */
function allNodeTypes(): void
{
}

?>
-----
<?php

namespace MartinCamen\RectorRules\Tests\Fixture\SingleLineDocBlock;

/** @mixin \Illuminate\Database\Eloquent\Builder */
class AllNodeTypes
{
    /** @var array<int, string> */
    public const array NAMES = ['first'];

    /** @var array<int, string> */
    private array $names = [];

    /** @return array<int, string> */
    public function names(): array
    {
        return $this->names;
    }
}

/** @deprecated */
interface AllNodeTypesContract
{
}

/** @deprecated */
trait AllNodeTypesTrait
{
}

/** @deprecated */
enum AllNodeTypesEnum: string
{
    /** @deprecated */
    case First = 'first';
}

/** @throws \Throwable */
function allNodeTypes(): void
{
}

?>
