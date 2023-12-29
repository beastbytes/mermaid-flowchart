<?php

use BeastBytes\Mermaid\Flowchart\ArrowHead;
use BeastBytes\Mermaid\Flowchart\Link;
use BeastBytes\Mermaid\Flowchart\LinkStyle;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Mermaid;

const TEXT = 'Text';
const MARKDOWN_TEXT = '*Markdown* Text';

test('Simple link', function () {
    $node0 = new Node('node0');
    $node1 = new Node('node1');

    $link = new Link($node0, $node1);

    expect($link->render(Mermaid::INDENTATION))
        ->toBe('  _node0 --> _node1')
    ;
});

test('Link styles', function (
    LinkStyle $style,
    int $length,
    ArrowHead $arrowHead,
    bool $biDirectional,
    string $result
) {
    $node0 = new Node('node0');
    $node1 = new Node('node1');

    $link = new Link(
        node0: $node0,
        node1: $node1,
        style: $style,
        length: $length,
        arrowHead: $arrowHead,
        biDirectional: $biDirectional
    );

    expect($link->render(Mermaid::INDENTATION))
        ->toBe($result)
    ;
})
    ->with('linkStyle')
;

test('Link with text', function (string $text, bool $isMarkdown, string $result) {
    $node0 = new Node('node0');
    $node1 = new Node('node1');

    $link = new Link($node0, $node1, $text, $isMarkdown);

    expect($link->render(Mermaid::INDENTATION))
        ->toBe($result)
    ;
})
    ->with('text')
;

dataset('linkStyle', [
    [LinkStyle::Solid, 1, ArrowHead::Default, false, '  _node0 --> _node1'],
    [LinkStyle::Dotted, 1, ArrowHead::Default, false, '  _node0 -.-> _node1'],
    [LinkStyle::Thick, 1, ArrowHead::Default, false, '  _node0 -=-> _node1'],
    [LinkStyle::Solid, 1, ArrowHead::O, false, '  _node0 --o _node1'],
    [LinkStyle::Dotted, 1, ArrowHead::O, false, '  _node0 -.-o _node1'],
    [LinkStyle::Thick, 1, ArrowHead::O, false, '  _node0 -=-o _node1'],
    [LinkStyle::Solid, 1, ArrowHead::X, false, '  _node0 --x _node1'],
    [LinkStyle::Dotted, 1, ArrowHead::X, false, '  _node0 -.-x _node1'],
    [LinkStyle::Thick, 1, ArrowHead::X, false, '  _node0 -=-x _node1'],
    [LinkStyle::Solid, 2, ArrowHead::Default, false, '  _node0 ---> _node1'],
    [LinkStyle::Dotted, 2, ArrowHead::Default, false, '  _node0 -..-> _node1'],
    [LinkStyle::Thick, 2, ArrowHead::Default, false, '  _node0 -==-> _node1'],
    [LinkStyle::Solid, 2, ArrowHead::O, false, '  _node0 ---o _node1'],
    [LinkStyle::Dotted, 2, ArrowHead::O, false, '  _node0 -..-o _node1'],
    [LinkStyle::Thick, 2, ArrowHead::O, false, '  _node0 -==-o _node1'],
    [LinkStyle::Solid, 2, ArrowHead::X, false, '  _node0 ---x _node1'],
    [LinkStyle::Dotted, 2, ArrowHead::X, false, '  _node0 -..-x _node1'],
    [LinkStyle::Thick, 2, ArrowHead::X, false, '  _node0 -==-x _node1'],
    [LinkStyle::Solid, 1, ArrowHead::Default, true, '  _node0 <--> _node1'],
    [LinkStyle::Dotted, 1, ArrowHead::Default, true, '  _node0 <-.-> _node1'],
    [LinkStyle::Thick, 1, ArrowHead::Default, true, '  _node0 <-=-> _node1'],
    [LinkStyle::Solid, 1, ArrowHead::O, true, '  _node0 o--o _node1'],
    [LinkStyle::Dotted, 1, ArrowHead::O, true, '  _node0 o-.-o _node1'],
    [LinkStyle::Thick, 1, ArrowHead::O, true, '  _node0 o-=-o _node1'],
    [LinkStyle::Solid, 1, ArrowHead::X, true, '  _node0 x--x _node1'],
    [LinkStyle::Dotted, 1, ArrowHead::X, true, '  _node0 x-.-x _node1'],
    [LinkStyle::Thick, 1, ArrowHead::X, true, '  _node0 x-=-x _node1'],
    [LinkStyle::Invisible, 1, ArrowHead::Default, false, '  _node0 ~~~ _node1'],
    [LinkStyle::Invisible, 2, ArrowHead::Default, false, '  _node0 ~~~~ _node1'],
]);

dataset('text', [
    [TEXT, false, '  _node0 -->|"' . TEXT . '"| _node1'],
    [MARKDOWN_TEXT, true, '  _node0 -->|"`' . MARKDOWN_TEXT . '`"| _node1'],
]);
