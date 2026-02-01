<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

trait GraphTrait
{
    /** @var list<Edge> */
    private array $edges = [];
    /** @var list<NodeInterface> */
    private array $nodes = [];
    /** @var list<SubGraph> */
    private array $subGraphs = [];

    public function addEdge(Edge ...$edge): self
    {
        $new = clone $this;
        $new->edges = array_merge($this->edges, $edge);
        return $new;
    }

    public function addNode(NodeInterface ...$node): self
    {
        $new = clone $this;
        $new->nodes = array_merge($this->nodes, $node);
        return $new;
    }

    public function addSubGraph(SubGraph ...$subGraph): self
    {
        $new = clone $this;
        $new->subGraphs = array_merge($this->subGraphs, $subGraph);
        return $new;
    }

    public function withEdge(Edge ...$edge): self
    {
        $new = clone $this;
        $new->edges = $edge;
        return $new;
    }

    public function withNode(NodeInterface ...$node): self
    {
        $new = clone $this;
        $new->nodes = $node;
        return $new;
    }

    public function withSubGraph(SubGraph ...$subGraph): self
    {
        $new = clone $this;
        $new->subGraphs = $subGraph;
        return $new;
    }
}