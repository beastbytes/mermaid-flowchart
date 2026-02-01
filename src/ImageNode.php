<?php

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\IdTrait;
use BeastBytes\Mermaid\InteractionInterface;
use BeastBytes\Mermaid\InteractionTrait;
use BeastBytes\Mermaid\StyleClassTrait;
use BeastBytes\Mermaid\TextTrait;

final class ImageNode implements InteractionInterface, LinkableInterface, NodeInterface
{
    use CommentTrait;
    use IdTrait;
    use InteractionTrait;
    use LabelPositionTrait;
    use StyleClassTrait;
    use TextTrait;

    private const string CONSTRAINT_OFF = 'off';
    private const string CONSTRAINT_ON = 'on';
    private const string SHAPE = '@%s';

    private ?int $h = null;
    private ?int $w = null;

    public function __construct(private readonly string $url, ?string $id = null)
    {
        $this->id = $id;
    }

    public function withSize(int $h, ?int $w): self
    {
        $new = clone $this;
        $new->h = $h;
        $new->w = $w;
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
            . $this->renderShape()
        ;

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }

    private function renderShape(): string
    {
        $output = [];

        $output['img'] = $this->url;
        $output['label'] = $this->text;
        $output['pos'] = $this->position instanceof LabelPosition ? $this->position->value : '';
        $output['h'] = $this->h;
        $output['w'] = $this->w;
        $output['constraint'] = is_int($this->h) && is_null($this->w) ? self::CONSTRAINT_ON : self::CONSTRAINT_OFF;

        return sprintf(
            self::SHAPE,
            json_encode(array_filter($output, fn($v) => !empty($v)), JSON_FORCE_OBJECT)
        );
    }
}