<?php

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\IdTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\StyleClassTrait;
use BeastBytes\Mermaid\TextTrait;

final class Node implements InteractionInterface, LinkableInterface, NodeInterface
{
    use CommentTrait;
    use IdTrait;
    use InteractionTrait;
    use StyleClassTrait;
    use TextTrait;

    private const string SHAPE = '@%s';

    public function __construct(
        private readonly NodeShape $shape = NodeShape::process,
        ?string $id = null,
    )
    {
        $this->id = $id;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $this->renderComment($indentation);
        $output[] = $indentation
            . $this->getId()
            . $this->getStyleClass()
            . $this->renderShape()
        ;

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }

    private function renderShape(): string
    {
        $text = $this->getText();

        return sprintf(
            self::SHAPE,
            json_encode(
                [
                    'shape' => $this->shape->value,
                    'label' => $text ?: $this->getId()
                ],
                JSON_FORCE_OBJECT
            )
        );
    }
}