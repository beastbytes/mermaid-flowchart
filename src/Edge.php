<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\TextTrait;
use InvalidArgumentException;
use RuntimeException;

final class Edge
{
    use TextTrait;

    private const string EDGE = '%s%s%s%s%s';
    private const int INVISIBLE_LENGTH = 3;
    private const string LINK = '%s%s %s %s';
    private const int MIN_LENGTH = 1;
    private const string MIN_LENGTH_EXCEPTION = '`minLength` must be > 0';
    private const string TEXT = '|%s|';
    private const string REVERSE_ARROW = '<';

    private bool $biDirectional = false;
    private ?EdgeId $edgeId = null;

    public function __construct(
        private readonly LinkableInterface $from,
        private readonly LinkableInterface $to,
        private readonly EdgeStyle $style = EdgeStyle::solid,
        private readonly int $minLength = self::MIN_LENGTH,
        private readonly Arrowhead $arrowhead = Arrowhead::arrow
    )
    {
    }

    public function bidirectional(): self
    {
        $new = clone $this;
        $new->biDirectional = true;
        return $new;
    }

    public function withEdgeId(EdgeId $edgeId): self
    {
        $new = clone $this;
        $new->edgeId = $edgeId;
        return $new;
    }

    /** @internal */
    public function render(string $indentation): string
    {

        return sprintf(
            self::LINK,
            $indentation,
            $this->from->getId(),
            $this->renderEdge(),
            $this->to->getId()
        );
    }

    private function renderEdge(): string
    {
        if ($this->style === EdgeStyle::invisible) {
            if ($this->biDirectional) {
                throw new RuntimeException('Invisible links cannot be bidirectional');
            }
            if ($this->edgeId instanceof EdgeId) {
                throw new RuntimeException('Invisible links cannot have an edge id');
            }
            if (is_string($this->text)) {
                throw new RuntimeException('Invisible links cannot have test');
            }
            $arrowhead = $reverseArrowhead = Arrowhead::open->value;
            $edge = str_repeat(EdgeStyle::invisible->value, self::INVISIBLE_LENGTH);
        } else {
            if ($this->minLength < self::MIN_LENGTH) {
                throw new InvalidArgumentException(self::MIN_LENGTH_EXCEPTION);
            }

            $arrowhead = $this->arrowhead->value;
            if ($this->biDirectional) {
                $reverseArrowhead = $this->arrowhead === Arrowhead::arrow
                    ? self::REVERSE_ARROW
                    : $this->arrowhead->value
                ;
            } else {
                $reverseArrowhead = Arrowhead::open->value;
            }

            $edge = str_repeat($this->style->value, $this->minLength);

            if ($this->style === EdgeStyle::dotted) {
                $edge = EdgeStyle::solid->value . $edge . EdgeStyle::solid->value;
            } else {
                if ($arrowhead === Arrowhead::open->value) {
                    $arrowhead = $this->style->value;
                }
                if ($reverseArrowhead === Arrowhead::open->value) {
                    $reverseArrowhead = $this->style->value;
                }
            }
        }

        return sprintf(
            self::EDGE,
            $this->edgeId instanceof EdgeId ? $this->edgeId->render() : '',
            $reverseArrowhead,
            $edge,
            $arrowhead,
            is_string($this->text) ? sprintf(self::TEXT, $this->getText(true)) : ''
        );
    }
}