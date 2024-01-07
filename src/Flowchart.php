<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\ClassDefTrait;
use BeastBytes\Mermaid\DirectionTrait;
use BeastBytes\Mermaid\Mermaid;
use BeastBytes\Mermaid\MermaidInterface;
use BeastBytes\Mermaid\RenderItemsTrait;
use BeastBytes\Mermaid\TitleTrait;
use Stringable;

final class Flowchart implements MermaidInterface, Stringable
{
    use ClassDefTrait;
    use DirectionTrait;
    use GraphTrait;
    use RenderItemsTrait;
    use TitleTrait;

    private const TYPE = 'flowchart';

    public function __construct(
        private readonly string $title = ''
    )
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        $output = [];

        if ($this->title !== '') {
            $output[] = $this->getTitle();
        }

        $output[] = self::TYPE . ' ' . $this->direction->name;

        if (count($this->subGraphs) > 0) {
            $output[] = $this->renderItems($this->subGraphs, '');
        }
        if (count($this->nodes) > 0) {
            $output[] = $this->renderItems($this->nodes, '');
        }
        if (count($this->links) > 0) {
            $output[] = $this->renderItems($this->links, '');
        }

        if (!empty($this->classDefs)) {
            $output[] = $this->renderClassDefs(Mermaid::INDENTATION);
        }

        return Mermaid::render($output);
    }
}
