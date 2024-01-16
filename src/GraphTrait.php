<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
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
    /** @var SubGraph[] */
    private array $subGraphs = [];

    public function addLink(Link ...$link): self
    {
        $new = clone $this;
        $new->links = array_merge($new->links, $link);
        return $new;
    }

    public function withLink(Link ...$link): self
    {
        $new = clone $this;
        $new->links = $link;
        return $new;
    }

    public function addNode(Node ...$node): self
    {
        $new = clone $this;
        $new->nodes = array_merge($new->nodes, $node);
        return $new;
    }

    public function withNode(Node ...$node): self
    {
        $new = clone $this;
        $new->nodes = $node;
        return $new;
    }

    public function addSubGraph(SubGraph ...$subGraph): self
    {
        $new = clone $this;
        $new->subGraphs = array_merge($new->subGraphs, $subGraph);
        return $new;
    }

    public function withSubGraph(SubGraph ...$subGraph): self
    {
        $new = clone $this;
        $new->subGraphs = $subGraph;
        return $new;
    }
}
