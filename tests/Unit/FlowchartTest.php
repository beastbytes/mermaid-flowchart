<?php

use BeastBytes\Mermaid\Flowchart\Flowchart;
use BeastBytes\Mermaid\Flowchart\Link;
use BeastBytes\Mermaid\Flowchart\Node;

const TITLE = 'Title';

test('Flowchart with styles', function () {
    $node0 = new Node('node0');
    $node1 = new Node('node1');
    $node2 = new Node('node2');
    $node3 = new Node('node3');

    $link0 = new Link($node0, $node1);
    $link1 = new Link($node1, $node2);
    $link2 = new Link($node1, $node3);

    $flowchart = new Flowchart(TITLE);
    $flowchart
        ->node($node0)
        ->node($node1)
        ->node($node2)
        ->node($node3)
        ->link($link0)
        ->link($link1)
        ->link($link2)
        ->classDef('classDef0', 'fill:white')
        ->classDef('classDef1', ['font-style' => 'italic'])
        ->classDef('classDef2', [
            'fill' => '#f00',
            'color' => 'white',
            'font-weight' => 'bold',
            'stroke-width' => '2px',
            'stroke' => 'yellow'
        ])
        ->class('classDef0', [$node0, $node1])
        ->class('classDef1', [$node0, $node2])
        ->class('classDef2', [$node3])
    ;

    expect($flowchart->render())
        ->toBe("<pre class=\"mermaid\">\n"
            . "---\n"
            . "Title\n"
            . "---\n"
            . "flowchart TB\n"
            . "  _node0[&quot;node0&quot;]\n"
            . "  _node1[&quot;node1&quot;]\n"
            . "  _node2[&quot;node2&quot;]\n"
            . "  _node3[&quot;node3&quot;]\n"
            . "  _node0 --&gt; _node1\n"
            . "  _node1 --&gt; _node2\n"
            . "  _node1 --&gt; _node3\n"
            . "  classDef classDef0 fill:white\n"
            . "  classDef classDef1 font-style:italic\n"
            . "  classDef classDef2 fill:#f00,color:white,font-weight:bold,stroke-width:2px,stroke:yellow\n"
            . "  class _node0,_node1 classDef0\n"
            . "  class _node0,_node2 classDef1\n"
            . "  class _node3 classDef2\n"
            . '</pre>'
        )
    ;
});
