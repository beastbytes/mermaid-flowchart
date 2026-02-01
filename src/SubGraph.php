<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\DirectionTrait;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\RenderItemsTrait;

final class SubGraph implements LinkableInterface
{
    use CommentTrait;
    use DirectionTrait;
    use GraphTrait;
    use InteractionRendererTrait;
    use RenderItemsTrait;

    private const string DIRECTION = 'direction %s';
    private const string END = 'end';
    private const string ID = '%s [%s]';
    private const string TITLE = ' %s';
    private const string SUBGRAPH = 'subgraph%s';

    public function __construct(
        private readonly ?string $title = null,
        private readonly ?string $id = null
    )
    {
    }

    /** @internal */
    public function render(string $indentation): string
    {
        $output = [];

        $output[] = $this->renderComment($indentation);

        $title = $this->title;
        if (is_string($title) && is_string($this->id)) {
            $title = sprintf(self::ID, $this->id, $this->title);
        }

        $output[] = $indentation . sprintf(
            self::SUBGRAPH,
            (is_string($title) ? sprintf(self::TITLE, $title) : '')
        );
        $output[] = $indentation . Mermaid::INDENTATION . sprintf(self::DIRECTION, $this->direction->name);
        $output[] = $this->renderItems($this->subGraphs, $indentation);
        $output[] = $this->renderItems($this->nodes, $indentation);
        $output[] = $this->renderItems($this->edges, $indentation);
        $output[] = $this->renderInteractions($this->nodes);
        $output[] = $indentation . self::END;

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }
}