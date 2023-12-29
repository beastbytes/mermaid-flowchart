<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

trait GraphTrait
{
    /** @var Link[] */
    private array $links = [];
    /** @var Node[] */
    private array $nodes = [];

    public function link(Link $link): self
    {
        $this->links[] = $link;
        return $this;
    }

    public function node(Node $node): self
    {
        $this->nodes[] = $node;
        return $this;
    }
}
