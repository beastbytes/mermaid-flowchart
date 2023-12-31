<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\StyleClassTrait;
use Stringable;

final class Flowchart implements MermaidInterface, Stringable
{
    use GraphTrait;
    use StyleClassTrait;

    public const TITLE = "---\ntitle: %s\n---";
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
            $output[] = sprintf(self::TITLE, $this->title);
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
            $output[] = $this->getStyleClass(Mermaid::INDENTATION);
        }

        return Mermaid::render($output);
    }
}
