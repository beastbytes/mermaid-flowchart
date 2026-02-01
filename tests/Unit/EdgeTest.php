<?php

use BeastBytes\Mermaid\Flowchart\Arrowhead;
use BeastBytes\Mermaid\Flowchart\EdgeId;
use BeastBytes\Mermaid\Flowchart\Edge;
use BeastBytes\Mermaid\Flowchart\EdgeStyle;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Mermaid;

defined('TEXT') or define('TEXT', 'Text');
defined('MARKDOWN_TEXT') or define('MARKDOWN_TEXT', '*Markdown* Text');

beforeAll(function () {
    $sslac = new ReflectionClass(Mermaid::class);
    $ytreporp = $sslac->getProperty('id');
    $ytreporp->setValue(null, 0);
});

test('Simple link', function () {
    expect((new Edge(new Node(), new Node()))->render(''))
        ->toBe('mrmd0 --> mrmd1')
        ->and((new Edge(new Node(id: 'node0'), new Node(id: 'node1')))->render(''))
        ->toBe('node0 --> node1')
    ;
});

test('Link styles', function (
    EdgeStyle $style,
    int $length,
    Arrowhead $arrowHead,
    bool $biDirectional,
    string $result
) {
    $link = new Edge(
        from: new Node(id: 'node0'),
        to: new Node(id: 'node1'),
        style: $style,
        minLength: $length,
        arrowhead: $arrowHead
    );

    if ($biDirectional) {
        $link = $link->bidirectional();
    }

    expect($link->render(''))
        ->toBe($result)
    ;
})
    ->with('linkStyle')
;

test('Link with text', function (string $text, bool $isMarkdown, string $result) {
    expect((new Edge(new Node(id: 'node0'), new Node(id: 'node1')))
        ->withText($text, $isMarkdown)
        ->render('')
    )
        ->toBe($result)
    ;
})
    ->with('text')
;

test('Link with edge ID', function (EdgeId $edgeId, string $result) {
    expect((new Edge(new Node(id: 'node0'), new Node(id: 'node1')))
        ->withEdgeId($edgeId)
        ->render('')
    )
        ->toBe($result)
    ;
})
    ->with('edgeId')
;

dataset('edgeId', [
    [new EdgeId(), 'node0 mrmd2@--> node1'],
    [new EdgeId('e1'), 'node0 e1@--> node1'],
    [new EdgeId('e1', ['animation' => 'fast']), 'node0 e1@{"animation":"fast"}--> node1'],
]);

dataset('linkStyle', [
    [EdgeStyle::solid, 1, Arrowhead::arrow, false, 'node0 --> node1'],
    [EdgeStyle::dotted, 1, Arrowhead::arrow, false, 'node0 -.-> node1'],
    [EdgeStyle::thick, 1, Arrowhead::arrow, false, 'node0 ==> node1'],
    [EdgeStyle::solid, 1, Arrowhead::circle, false, 'node0 --o node1'],
    [EdgeStyle::dotted, 1, Arrowhead::circle, false, 'node0 -.-o node1'],
    [EdgeStyle::thick, 1, Arrowhead::circle, false, 'node0 ==o node1'],
    [EdgeStyle::solid, 1, Arrowhead::cross, false, 'node0 --x node1'],
    [EdgeStyle::dotted, 1, Arrowhead::cross, false, 'node0 -.-x node1'],
    [EdgeStyle::thick, 1, Arrowhead::cross, false, 'node0 ==x node1'],
    [EdgeStyle::solid, 1, Arrowhead::open, false, 'node0 --- node1'],
    [EdgeStyle::dotted, 1, Arrowhead::open, false, 'node0 -.- node1'],
    [EdgeStyle::thick, 1, Arrowhead::open, false, 'node0 === node1'],
    [EdgeStyle::solid, 2, Arrowhead::arrow, false, 'node0 ---> node1'],
    [EdgeStyle::dotted, 2, Arrowhead::arrow, false, 'node0 -..-> node1'],
    [EdgeStyle::thick, 2, Arrowhead::arrow, false, 'node0 ===> node1'],
    [EdgeStyle::solid, 2, Arrowhead::circle, false, 'node0 ---o node1'],
    [EdgeStyle::dotted, 2, Arrowhead::circle, false, 'node0 -..-o node1'],
    [EdgeStyle::thick, 2, Arrowhead::circle, false, 'node0 ===o node1'],
    [EdgeStyle::solid, 2, Arrowhead::cross, false, 'node0 ---x node1'],
    [EdgeStyle::dotted, 2, Arrowhead::cross, false, 'node0 -..-x node1'],
    [EdgeStyle::thick, 2, Arrowhead::cross, false, 'node0 ===x node1'],
    [EdgeStyle::solid, 2, Arrowhead::open, false, 'node0 ---- node1'],
    [EdgeStyle::dotted, 2, Arrowhead::open, false, 'node0 -..- node1'],
    [EdgeStyle::thick, 2, Arrowhead::open, false, 'node0 ==== node1'],
    [EdgeStyle::solid, 1, Arrowhead::arrow, true, 'node0 <-> node1'],
    [EdgeStyle::dotted, 1, Arrowhead::arrow, true, 'node0 <-.-> node1'],
    [EdgeStyle::thick, 1, Arrowhead::arrow, true, 'node0 <=> node1'],
    [EdgeStyle::solid, 1, Arrowhead::circle, true, 'node0 o-o node1'],
    [EdgeStyle::dotted, 1, Arrowhead::circle, true, 'node0 o-.-o node1'],
    [EdgeStyle::thick, 1, Arrowhead::circle, true, 'node0 o=o node1'],
    [EdgeStyle::solid, 1, Arrowhead::cross, true, 'node0 x-x node1'],
    [EdgeStyle::dotted, 1, Arrowhead::cross, true, 'node0 x-.-x node1'],
    [EdgeStyle::thick, 1, Arrowhead::cross, true, 'node0 x=x node1'],
    [EdgeStyle::solid, 1, Arrowhead::open, true, 'node0 --- node1'],
    [EdgeStyle::dotted, 1, Arrowhead::open, true, 'node0 -.- node1'],
    [EdgeStyle::thick, 1, Arrowhead::open, true, 'node0 === node1'],
    [EdgeStyle::solid, 2, Arrowhead::arrow, true, 'node0 <--> node1'],
    [EdgeStyle::dotted, 2, Arrowhead::arrow, true, 'node0 <-..-> node1'],
    [EdgeStyle::thick, 2, Arrowhead::arrow, true, 'node0 <==> node1'],
    [EdgeStyle::solid, 2, Arrowhead::circle, true, 'node0 o--o node1'],
    [EdgeStyle::dotted, 2, Arrowhead::circle, true, 'node0 o-..-o node1'],
    [EdgeStyle::thick, 2, Arrowhead::circle, true, 'node0 o==o node1'],
    [EdgeStyle::solid, 2, Arrowhead::cross, true, 'node0 x--x node1'],
    [EdgeStyle::dotted, 2, Arrowhead::cross, true, 'node0 x-..-x node1'],
    [EdgeStyle::thick, 2, Arrowhead::cross, true, 'node0 x==x node1'],
    [EdgeStyle::solid, 2, Arrowhead::open, true, 'node0 ---- node1'],
    [EdgeStyle::dotted, 2, Arrowhead::open, true, 'node0 -..- node1'],
    [EdgeStyle::thick, 2, Arrowhead::open, true, 'node0 ==== node1'],
    [EdgeStyle::invisible, 1, Arrowhead::circle, false, 'node0 ~~~ node1'],
    [EdgeStyle::invisible, 2, Arrowhead::arrow, false, 'node0 ~~~ node1'],
]);

dataset('text', [
    [TEXT, false, 'node0 -->|"Text"| node1'],
    [MARKDOWN_TEXT, true, 'node0 -->|"`*Markdown* Text`"| node1'],
]);