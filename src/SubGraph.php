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

    private const END = 'end';
    private const TYPE = 'subgraph';

    public function __construct(
        private readonly Direction $direction = Direction::TB,
        private readonly string $title = ''
    )
    {
    }

    public function render(string $indentation): string
    {
        /** @psalm-var list<string> $output */
        $output = [];

        $output[] = $indentation . self::TYPE . ($this->title !== '' ? '' : ' ' . $this->title);
        $output[] = $indentation . $this->direction->name;

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
