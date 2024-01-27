<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\ClassDefTrait;
use BeastBytes\Mermaid\CommentTrait;
use BeastBytes\Mermaid\DirectionTrait;
use BeastBytes\Mermaid\InteractionRendererTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\TitleTrait;
use Stringable;

final class Flowchart implements MermaidInterface, Stringable
{
    use ClassDefTrait;
    use CommentTrait;
    use DirectionTrait;
    use GraphTrait;
    use InteractionRendererTrait;
    use RenderItemsTrait;
    use TitleTrait;

    private const TYPE = 'flowchart';

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(array $attributes = []): string
    {
        $output = [];

        $this->renderComment('', $output);
        $this->renderTitle($output);

        $output[] = self::TYPE . ' ' . $this->direction->name;

        $this->renderItems($this->subGraphs, '', $output);
        $this->renderItems($this->nodes, '', $output);
        $this->renderItems($this->links, '', $output);
        $this->renderInteractions($this->nodes, $output);
        $this->renderClassDefs($output);

        return Mermaid::render($output, $attributtes);
    }
}
