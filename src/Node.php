<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\NodeInterface;
use BeastBytes\Mermaid\NodeTrait;
use BeastBytes\Mermaid\StyleClassTrait;
use BeastBytes\Mermaid\TextTrait;

final class Node implements InteractionInterface, NodeInterface
{
    use CommentTrait;
    use InteractionTrait;
    use NodeTrait;
    use StyleClassTrait;
    use TextTrait;

    public function __construct(
        private readonly string $id,
        private readonly NodeShape $shape = NodeShape::Rectangle,
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        if ($this->text === '') {
            $this->text = $this->id;
        }

        $output = [];

        $this->renderComment($indentation, $output);

        $output[] = $indentation
            . $this->getId()
            . $this->getStyleClass()
            . str_replace('%s', $this->getText(), $this->shape->value)
        ;

        return implode("\n", $output);
    }
}
