<?php

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\IdTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\StyleClassTrait;
use BeastBytes\Mermaid\TextTrait;

final class IconNode implements InteractionInterface, LinkableInterface, NodeInterface
{
    use CommentTrait;
    use IdTrait;
    use InteractionTrait;
    use LabelPositionTrait;
    use StyleClassTrait;
    use TextTrait;

    private const string ICON = '@%s';

    private ?int $h = null;
    private ?IconShape $shape = null;

    public function __construct(
        private readonly string $icon,
        ?string $id = null
    )
    {
        $this->id = $id;
    }

    public function withHeight(int $h)
    {
        $new = clone $this;
        $new->h = $h;
        return $new;
    }

    public function withShape(IconShape $shape)
    {
        $new = clone $this;
        $new->shape = $shape;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $this->renderComment($indentation);
        $output[] = $indentation
            . $this->getId()
            . $this->getStyleClass()
            . $this->renderIcon()
        ;

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }

    private function renderIcon(): string
    {
        $output = [];

        $output['icon'] = $this->icon;
        $output['form'] = $this->shape instanceof IconShape ? $this->shape->name : '';
        $output['label'] = $this->text;
        $output['pos'] = $this->position instanceof LabelPosition ? $this->position->value : '';
        $output['h'] = $this->h;

        return sprintf(
            self::ICON,
            json_encode(array_filter($output, fn($v) => !empty($v)), JSON_FORCE_OBJECT)
        );
    }
}