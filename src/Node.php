<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\NodeInterface;
use BeastBytes\Mermaid\NodeTrait;
use BeastBytes\Mermaid\StyleClassTrait;
use BeastBytes\Mermaid\TextTrait;

final class Node implements NodeInterface
{
    use NodeTrait;
    use StyleClassTrait;
    use TextTrait;

    public function __construct(
        private readonly string $id,
        private readonly NodeShape $shape = NodeShape::Rectangle,
        private string $text = '',
        private readonly bool $isMarkdown = false,
        private readonly string $styleClass = ''
    )
    {
        if ($this->text === '') {
            $this->text = $this->id;
        }
    }

    /** @internal */
    public function render(string $indentation): string
    {
        return $indentation
            . $this->getId()
            . $this->getStyleClass()
            . sprintf($this->shape->value, $this->getText())
        ;
    }
}
