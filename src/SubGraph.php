<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;

final class SubGraph
{
    use CommentTrait;
    use GraphTrait;
    use InteractionRendererTrait;
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

        $this->renderComment($indentation, $output);

        $title = $this->title;
        if ($title !== '' && $this->id !== '') {
            $title = $this->id . ' [' . $this->title . ']';
        }

        $output[] = $indentation . self::TYPE . ($title === '' ? '' : ' ' . $title);
        $output[] = $indentation . Mermaid::INDENTATION . self::DIRECTION . ' ' . $this->direction->name;

        $this->renderItems($this->subGraphs, $indentation, $output);
        $this->renderItems($this->nodes, $indentation, $output);
        $this->renderItems($this->links, $indentation, $output);
        $this->renderInteractions($this->nodes, $output);

        $output[] = $indentation . self::END;

        return implode("\n", $output);
    }
}
