<?php

declare(strict_types=1);

namespace MartinCamen\RectorRules;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\EnumCase;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Trait_;
use Rector\Rector\AbstractRector;

/**
 * Base for rules that rewrite the raw text of a doc block instead of its parsed representation.
 *
 * Rector prints doc blocks while preserving their original line breaks, so a rule that has to change the layout
 * itself has to work on the text.
 */
abstract class AbstractDocBlockRector extends AbstractRector
{
    /** @return array<class-string<Node>> */
    public function getNodeTypes(): array
    {
        return [
            Class_::class,
            ClassConst::class,
            ClassMethod::class,
            Enum_::class,
            EnumCase::class,
            Function_::class,
            Interface_::class,
            Property::class,
            Trait_::class,
        ];
    }

    /**
     * The node is cloned on purpose. Rector caches the parsed doc block per node object, and rules and post rectors
     * running after this one print that cache back over the node. Handing them a node they have not parsed yet makes
     * them re-read, and keep, the rewritten doc block.
     */
    public function refactor(Node $node): ?Node
    {
        $docComment = $node->getDocComment();

        if (! $docComment instanceof Doc) {
            return null;
        }

        $docBlock = $this->refactorDocBlock($docComment->getText());

        if ($docBlock === null || $docBlock === $docComment->getText()) {
            return null;
        }

        $clonedNode = clone $node;
        $clonedNode->setDocComment(new Doc($docBlock));

        return $clonedNode;
    }

    /**
     * Returns the rewritten doc block, or null when it must be left alone.
     */
    abstract protected function refactorDocBlock(string $docBlock): ?string;

    /**
     * Splits a doc block into its lines, or returns null when it is not a multi line doc block.
     *
     * @return array<int, string>|null
     */
    protected function splitIntoLines(string $docBlock): ?array
    {
        $lines = preg_split('#\R#', $docBlock);

        if ($lines === false || count($lines) < 3) {
            return null;
        }

        if (trim($lines[0]) !== '/**' || trim($lines[count($lines) - 1]) !== '*/') {
            return null;
        }

        return $lines;
    }
}
