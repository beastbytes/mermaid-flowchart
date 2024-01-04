<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;

final class SubGraph
{
    use GraphTrait;
    use RenderItemsTrait;

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

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $title = $this->title;
        if ($title !== '' && $this->id !== '') {
            $title = $this->id . ' [' . $this->title . ']';
        }

        $output[] = $indentation . self::TYPE . ($title === '' ? '' : ' ' . $title);
        $output[] = $indentation . Mermaid::INDENTATION . self::DIRECTION . ' ' . $this->direction->name;

        if (count($this->subGraphs) > 0) {
            $output[] = $this->renderItems($this->subGraphs, $indentation);
        }
        if (count($this->nodes) > 0) {
            $output[] = $this->renderItems($this->nodes, $indentation);
        }
        if (count($this->links) > 0) {
            $output[] = $this->renderItems($this->links, $indentation);
        }

        $output[] = $indentation . self::END;

        return implode("\n", $output);
    }
}
