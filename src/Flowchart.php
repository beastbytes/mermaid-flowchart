<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\StyleTrait;
use Stringable;

final class Flowchart implements MermaidInterface, Stringable
{
    use GraphTrait;
    use StyleTrait;

    public const TITLE_DELIMITER = '---';
    private const TYPE = 'flowchart';

    /** @var SubGraph[] */
    private array $subGraphs = [];

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

    public function subGraph(SubGraph $subGraph): self
    {
        $this->subGraphs[] = $subGraph;
        return $this;
    }

    public function render(): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        if ($this->title !== '') {
            $output[] = self::TITLE_DELIMITER;
            $output[] = $this->title;
            $output[] = self::TITLE_DELIMITER;
        }

        $output[] = self::TYPE . ' ' . $this->direction->name;

        foreach ($this->nodes as $node) {
            $output[] = $node->render(Mermaid::INDENTATION);
        }

        foreach ($this->links as $link) {
            $output[] = $link->render(Mermaid::INDENTATION);
        }

        foreach ($this->subGraphs as $subGraph) {
            $output[] = $subGraph->render(Mermaid::INDENTATION);
        }

        if (!empty($this->styleClasses)) {
            $output[] = $this->renderStyles(Mermaid::INDENTATION);
        }

        return Mermaid::render($output);
    }
}
