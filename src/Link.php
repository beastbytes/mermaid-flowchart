<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\TextTrait;

final class Link
{
    use TextTrait;

    private const TEXT = '|';
    private const REVERSE_DEFAULT_ARROWHEAD = '<';

    public function __construct(
        private readonly Node $node0,
        private readonly Node $node1,
        private readonly LinkStyle $style = LinkStyle::Solid,
        private readonly int $length = 1,
        private readonly ArrowHead $arrowHead = ArrowHead::Default,
        private readonly bool $biDirectional = false,
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $reverseArrowhead = '';
        if ($this->style === LinkStyle::Invisible) {
            $arrowhead = '';
            $link = str_repeat(LinkStyle::Invisible->value, $this->length + 2);
        } else {
            $arrowhead = $this->arrowHead->value;
            $link = LinkStyle::Solid->value
                . str_repeat(
                    $this->style->value,
                    $this->style === LinkStyle::Solid ? $this->length - 1 : $this->length
                )
                . LinkStyle::Solid->value
            ;

            if ($this->biDirectional) {
                $reverseArrowhead = $this->arrowHead === ArrowHead::Default
                    ? self::REVERSE_DEFAULT_ARROWHEAD
                    : $this->arrowHead->value
                ;
            }
        }

        return $indentation
            . $this->node0->getId()
            . ' '
            . $reverseArrowhead
            . $link
            . $arrowhead
            . ($this->text === '' ? '' : self::TEXT .  $this->getText() . self::TEXT)
            . ' '
            . $this->node1->getId()
        ;
    }
}
