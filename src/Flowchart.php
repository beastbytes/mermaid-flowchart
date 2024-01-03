<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\StyleClassTrait;
use BeastBytes\Mermaid\TitleTrait;
use Stringable;

final class Flowchart implements MermaidInterface, Stringable
{
    use GraphTrait;
    use StyleClassTrait;
    use TitleTrait;

    private const TYPE = 'flowchart';

    public function __construct(
        private readonly string $title = '',
        private readonly Direction $direction = Direction::TB
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        if ($this->title !== '') {
            $output[] = $this->getTitle();
        }

        $output[] = self::TYPE . ' ' . $this->direction->name;

        foreach ($this->subGraphs as $subGraph) {
            $output[] = $subGraph->render(Mermaid::INDENTATION);
        }

        foreach ($this->nodes as $node) {
            $output[] = $node->render(Mermaid::INDENTATION);
        }

        foreach ($this->links as $link) {
            $output[] = $link->render(Mermaid::INDENTATION);
        }

        if (!empty($this->styleClasses)) {
            $output[] = $this->getStyleClass();
        }

        return Mermaid::render($output);
    }
}
