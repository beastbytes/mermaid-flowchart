<?php

use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\Flowchart\Edge;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\SubGraph;
use BeastBytes\Mermaid\Mermaid;

defined('COMMENT') or define('COMMENT', 'Comment');

beforeAll(function () {
    $sslac = new ReflectionClass(Mermaid::class);
    $ytreporp = $sslac->getProperty('id');
    $ytreporp->setValue(null, 0);
});

test('SubGraph with comment', function () {
    $subgraph = (new SubGraph())
        ->withComment(COMMENT)
    ;

    expect($subgraph->render(''))
        ->toBe(<<<EXPECTED
%% Comment
subgraph
  direction TB
end
EXPECTED

        )
    ;
});

test('SubGraph with multiple nodes and links', function () {
    $node0 = (new Node)->withText('Node0');
    $node1 = (new Node)->withText('Node1');
    $node2 = (new Node)->withText('Node2');
    $node3 = (new Node)->withText('Node3');

    $link0 = new Edge($node0, $node1);
    $link1 = new Edge($node1, $node2);
    $link2 = new Edge($node1, $node3);

    $subgraph = (new SubGraph())
        ->withNode($node0, $node1, $node2)
        ->withLink($link0, $link1)
    ;

    expect($subgraph->render(''))
        ->toBe(<<<EXPECTED
subgraph
  direction TB
  mrmd0@{"shape":"process","label":"Node0"}
  mrmd1@{"shape":"process","label":"Node1"}
  mrmd2@{"shape":"process","label":"Node2"}
  mrmd0 --> mrmd1
  mrmd1 --> mrmd2
end
EXPECTED
        )
        ->and($subgraph
            ->addNode($node3)
            ->addLink($link2)
            ->render('')
        )
        ->toBe(<<<EXPECTED
subgraph
  direction TB
  mrmd0@{"shape":"process","label":"Node0"}
  mrmd1@{"shape":"process","label":"Node1"}
  mrmd2@{"shape":"process","label":"Node2"}
  mrmd3@{"shape":"process","label":"Node3"}
  mrmd0 --> mrmd1
  mrmd1 --> mrmd2
  mrmd1 --> mrmd3
end
EXPECTED
        )
    ;
});

test('Subgraph with subgraphs', function () {
    $node0 = (new Node(id: 'Node0'));
    $node1 = (new Node(id: 'Node1'));
    $node2 = (new Node(id: 'Node2'));
    $node3 = (new Node(id: 'Node3'));

    expect((new SubGraph())
        ->withSubGraph(
            (new SubGraph('Subgraph 0'))
                ->withNode($node0, $node1)
                ->withLink(new Edge($node0, $node1))
            ,
            (new SubGraph('Subgraph 1', 'sg1', direction: Direction::LR))
                ->withNode($node2, $node3)
                ->withLink(new Edge($node2, $node3))
        )
        ->withLink(new Edge($node1, $node2))
        ->render('')
    )
        ->toBe(<<<EXPECTED
subgraph
  direction TB
  subgraph Subgraph 0
    direction TB
    Node0@{"shape":"process","label":"Node0"}
    Node1@{"shape":"process","label":"Node1"}
    Node0 --> Node1
  end
  subgraph sg1 [Subgraph 1]
    direction LR
    Node2@{"shape":"process","label":"Node2"}
    Node3@{"shape":"process","label":"Node3"}
    Node2 --> Node3
  end
  Node1 --> Node2
end
EXPECTED
        )
    ;
});