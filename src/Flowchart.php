<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\ClassDefTrait;
use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\Diagram;
use BeastBytes\Mermaid\DirectionTrait;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\TitleTrait;

final class Flowchart extends Diagram
{
    use ClassDefTrait;
    use CommentTrait;
    use DirectionTrait;
    use GraphTrait;
    use InteractionRendererTrait;
    use RenderItemsTrait;
    use TitleTrait;

    private const string TYPE = 'flowchart';

    protected function renderDiagram(): string
    {
        $output = [];

        $output[] = $this->renderComment('');
        $output[] = $this->renderTitle('');
        $output[] = self::TYPE . ' ' . $this->direction->name;
        $output[] = $this->renderItems($this->subGraphs, '');
        $output[] = $this->renderItems($this->nodes, '');
        $output[] = $this->renderItems($this->edges, '');
        $output[] = $this->renderInteractions($this->nodes);
        $output[] = $this->renderClassDefs();

        return implode("\n", array_filter($output, fn($v) => !empty($v)));
    }
}