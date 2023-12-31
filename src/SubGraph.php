<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\Mermaid;

final class SubGraph
{
    use GraphTrait;

    private const DIRECTION = 'direction';
    private const END = 'end';
    private const TYPE = 'subgraph';

    public function __construct(
        private readonly string $title = '',
        private readonly string $id = '',
        private readonly Direction $direction = Direction::TB
    )
    {
    }

    public function render(string $indentation): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        $title = $this->title;
        if ($title !== '' && $this->id !== '') {
            $title = $this->id . ' [' . $this->title . ']';
        }

        $output[] = $indentation . self::TYPE . ($title === '' ? '' : ' ' . $title);
        $output[] = $indentation . Mermaid::INDENTATION . self::DIRECTION . ' ' . $this->direction->name;

        foreach ($this->subGraphs as $subGraph) {
            $output[] = $subGraph->render($indentation . Mermaid::INDENTATION);
        }

        foreach ($this->nodes as $node) {
            $output[] = $node->render($indentation . Mermaid::INDENTATION);
        }

        foreach ($this->links as $link) {
            $output[] = $link->render($indentation . Mermaid::INDENTATION);
        }

        $output[] = $indentation . self::END;

        return implode("\n", $output);
    }
}
