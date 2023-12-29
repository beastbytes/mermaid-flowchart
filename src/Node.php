<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\NodeInterface;
use BeastBytes\Mermaid\NodeTrait;
use BeastBytes\Mermaid\TextTrait;

final class Node implements NodeInterface
{
    use NodeTrait;
    use TextTrait;

    public function __construct(
        private readonly string $id,
        private readonly NodeShape $shape = NodeShape::Rectangle,
        private readonly ?string $text = null,
        private readonly bool $isMarkdown = false
    )
    {
    }

    public function getStyleClass(): string
    {
        return 'class';
    }

    public function render(string $indentation): string
    {
        return $indentation
            . $this->getId()
            . sprintf($this->shape->value, $this->getText($this->text ?? $this->id, $this->isMarkdown))
        ;
    }
}
