<?php

use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\Flowchart\Flowchart;
use BeastBytes\Mermaid\Flowchart\Link;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\SubGraph;
use BeastBytes\Mermaid\Mermaid;

defined('COMMENT') or define('COMMENT', 'Comment');
defined('NODE_ID') or define('NODE_ID', 'nodeId');
defined('TITLE') or define('TITLE', 'Title');

test('Simple Flowchart', function () {
    $flowchart = (new Flowchart())
        ->withNode(new Node(NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
               . "flowchart TB\n"
               . Mermaid::INDENTATION . '_' . NODE_ID . '[&quot;' . NODE_ID . "&quot;]\n"
               . '</pre>'
        )
    ;
});

test('Flowchart with comment', function () {
    $flowchart = (new Flowchart())
        ->withComment(COMMENT)
        ->withNode(new Node(NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . '%% ' . COMMENT . "\n"
            . "flowchart TB\n"
            . Mermaid::INDENTATION . '_' . NODE_ID . '[&quot;' . NODE_ID . "&quot;]\n"
            . '</pre>'
        )
    ;
});

test('Flowchart with direction', function (Direction $direction) {
    $flowchart = (new Flowchart())
        ->withDirection($direction)
        ->withNode(new Node(NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
               . 'flowchart ' . $direction->name . "\n"
               . Mermaid::INDENTATION . '_' . NODE_ID . '[&quot;' . NODE_ID . "&quot;]\n"
               . '</pre>'
        )
    ;
})
    ->with([Direction::BT, Direction::LR, Direction::RL, Direction::TB])
;

test('Flowchart with title', function () {
    $flowchart = (new Flowchart())
        ->withTitle(TITLE)
        ->withNode(new Node(NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . 'title: ' . TITLE . "\n"
            . "---\n"
            . "flowchart TB\n"
            . Mermaid::INDENTATION . '_' . NODE_ID . '[&quot;' . NODE_ID . "&quot;]\n"
            . '</pre>'
        )
    ;
});

test('Flowchart with classDefs', function () {
    $flowchart = (new Flowchart())
        ->withClassDef([
            'classDef0' => 'fill:white',
            'classDef1' => ['font-style' => 'italic']
        ])
        ->addClassDef(['classDef2' => [
            'fill' => '#f00',
            'color' => 'white',
            'font-weight' => 'bold',
            'stroke-width' => '2px',
            'stroke' => 'yellow'
        ]])
        ->withNode((new Node(NODE_ID))->withStyleClass('classDef1'))
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "flowchart TB\n"
            . Mermaid::INDENTATION . '_' . NODE_ID . ':::classDef1' . '[&quot;' . NODE_ID . "&quot;]\n"
            . Mermaid::INDENTATION . "classDef classDef0 fill:white;\n"
            . Mermaid::INDENTATION . "classDef classDef1 font-style:italic;\n"
            . Mermaid::INDENTATION . "classDef classDef2 fill:#f00,color:white,font-weight:bold,stroke-width:2px,stroke:yellow;\n"
            . '</pre>'
        )
    ;
});

test('Flowchart with multiple nodes and links', function () {
    $node0 = new Node('node0');
    $node1 = new Node('node1');
    $node2 = new Node('node2');
    $node3 = new Node('node3');

    $link0 = new Link($node0, $node1);
    $link1 = new Link($node1, $node2);
    $link2 = new Link($node1, $node3);

    $flowchart = (new Flowchart())
        ->withNode($node0, $node1, $node2)
        ->withLink($link0, $link1)
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "flowchart TB\n"
            . "  _node0[&quot;node0&quot;]\n"
            . "  _node1[&quot;node1&quot;]\n"
            . "  _node2[&quot;node2&quot;]\n"
            . "  _node0 --&gt; _node1\n"
            . "  _node1 --&gt; _node2\n"
            . '</pre>'
        )
        ->and($flowchart
            ->addNode($node3)
            ->addLink($link2)
            ->render()
        )
        ->toBe("<pre class=\"mermaid\">\n"
            . "flowchart TB\n"
            . "  _node0[&quot;node0&quot;]\n"
            . "  _node1[&quot;node1&quot;]\n"
            . "  _node2[&quot;node2&quot;]\n"
            . "  _node3[&quot;node3&quot;]\n"
            . "  _node0 --&gt; _node1\n"
            . "  _node1 --&gt; _node2\n"
            . "  _node1 --&gt; _node3\n"
            . '</pre>'
        )
    ;
});

test('Flowchart with subgraphs', function () {
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

    $flowchart = (new Flowchart())
        ->withSubGraph($subgraph0, $subgraph1)
        ->withLink($link1)
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "flowchart TB\n"
            . "  subgraph Subgraph 0\n"
            . "    direction TB\n"
            . "    _node0[&quot;node0&quot;]\n"
            . "    _node1[&quot;node1&quot;]\n"
            . "    _node0 --&gt; _node1\n"
            . "  end\n"
            . "  subgraph sg1 [Subgraph 1]\n"
            . "    direction LR\n"
            . "    _node2[&quot;node2&quot;]\n"
            . "    _node3[&quot;node3&quot;]\n"
            . "    _node2 --&gt; _node3\n"
            . "  end\n"
            . "  _node1 --&gt; _node2\n"
            . '</pre>'
        )
    ;
});
