<?php

use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\Flowchart\Link;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\SubGraph;

test('SubGraph with multiple nodes and links', function () {
    $node0 = new Node('node0');
    $node1 = new Node('node1');
    $node2 = new Node('node2');
    $node3 = new Node('node3');

    $link0 = new Link($node0, $node1);
    $link1 = new Link($node1, $node2);
    $link2 = new Link($node1, $node3);

    $subgraph = (new SubGraph())
        ->withNode($node0, $node1, $node2)
        ->withLink($link0, $link1)
    ;

    expect($subgraph->render(''))
        ->toBe("subgraph\n"
            . "  direction TB\n"
            . "  _node0[\"node0\"]\n"
            . "  _node1[\"node1\"]\n"
            . "  _node2[\"node2\"]\n"
            . "  _node0 --> _node1\n"
            . "  _node1 --> _node2\n"
            . "end"
        )
        ->and($subgraph
            ->addNode($node3)
            ->addLink($link2)
            ->render('')
        )
        ->toBe("subgraph\n"
            . "  direction TB\n"
            . "  _node0[\"node0\"]\n"
            . "  _node1[\"node1\"]\n"
            . "  _node2[\"node2\"]\n"
            . "  _node3[\"node3\"]\n"
            . "  _node0 --> _node1\n"
            . "  _node1 --> _node2\n"
            . "  _node1 --> _node3\n"
            . "end"
        )
    ;
});

test('Subgraph with subgraphs', function () {
    $node0 = new Node('node0');
    $node1 = new Node('node1');
    $node2 = new Node('node2');
    $node3 = new Node('node3');

    $link0 = new Link($node0, $node1);
    $link1 = new Link($node1, $node2);
    $link2 = new Link($node2, $node3);

    $subgraph0 = (new SubGraph('Subgraph 0'))
        ->withNode($node0, $node1)
        ->withLink($link0)
    ;

    $subgraph1 = (new SubGraph('Subgraph 1', 'sg1', direction: Direction::LR))
        ->withNode($node2, $node3)
        ->withLink($link2)
    ;

    $subgraph = (new SubGraph())
        ->withSubGraph($subgraph0, $subgraph1)
        ->withLink($link1)
    ;

    expect($subgraph->render(''))
        ->toBe("subgraph\n"
            . "  direction TB\n"
            . "  subgraph Subgraph 0\n"
            . "    direction TB\n"
            . "    _node0[\"node0\"]\n"
            . "    _node1[\"node1\"]\n"
            . "    _node0 --> _node1\n"
            . "  end\n"
            . "  subgraph sg1 [Subgraph 1]\n"
            . "    direction LR\n"
            . "    _node2[\"node2\"]\n"
            . "    _node3[\"node3\"]\n"
            . "    _node2 --> _node3\n"
            . "  end\n"
            . "  _node1 --> _node2\n"
            . "end"
        )
    ;
});
