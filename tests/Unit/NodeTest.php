<?php

use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\NodeShape;
use BeastBytes\Mermaid\Mermaid;

const TEXT = 'Text';
const MARKDOWN_TEXT = '*Markdown* Text';

const NODE_ID = 'node';

test('Simple node', function () {
    $node = new Node(NODE_ID);

    expect($node->render(Mermaid::INDENTATION))
        ->toBe('  _' . NODE_ID . '["' . NODE_ID . '"]')
    ;
    expect($node->getId())
        ->toBe('_' . NODE_ID)
    ;
});

test('Node shapes', function (NodeShape $shape, string $result) {
    $node = new Node(NODE_ID, $shape);

    expect($node->render(Mermaid::INDENTATION))
        ->toBe($result)
    ;
})
    ->with('nodeShapes')
;

test('Node with text', function (string $text, bool $isMarkdown, string $result) {
    $node = new Node(id: NODE_ID, text: $text, isMarkdown: $isMarkdown);

    expect($node->render(Mermaid::INDENTATION))
        ->toBe($result)
    ;
})
    ->with('text')
;

dataset('nodeShapes', [
    [NodeShape::Asymmetric, '  _' . NODE_ID . '>"' . NODE_ID . '"]'],
    [NodeShape::Circle, '  _' . NODE_ID . '(("' . NODE_ID . '"))'],
    [NodeShape::Cylinder, '  _' . NODE_ID . '[("' . NODE_ID . '")]'],
    [NodeShape::DoubleCircle, '  _' . NODE_ID . '((("' . NODE_ID . '")))'],
    [NodeShape::Hexagon, '  _' . NODE_ID . '{{"' . NODE_ID . '"}}'],
    [NodeShape::Parallelogram, '  _' . NODE_ID . '[/"' . NODE_ID . '"/]'],
    [NodeShape::ParallelogramAlt, '  _' . NODE_ID . '[\\"' . NODE_ID . '"\\]'],
    [NodeShape::Rectangle, '  _' . NODE_ID . '["' . NODE_ID . '"]'],
    [NodeShape::Rhombus, '  _' . NODE_ID . '{"' . NODE_ID . '"}'],
    [NodeShape::Rounded, '  _' . NODE_ID . '("' . NODE_ID . '")'],
    [NodeShape::Stadium, '  _' . NODE_ID . '(["' . NODE_ID . '"])'],
    [NodeShape::Subroutine, '  _' . NODE_ID . '[["' . NODE_ID . '"]]'],
    [NodeShape::Trapezoid, '  _' . NODE_ID . '[/"' . NODE_ID . '"\\]'],
    [NodeShape::TrapezoidAlt, '  _' . NODE_ID . '[\\"' . NODE_ID . '"/]'],
]);

dataset('text', [
    [TEXT, false, '  _' . NODE_ID . '["' . TEXT . '"]'],
    [MARKDOWN_TEXT, true, '  _' . NODE_ID . '["`' . MARKDOWN_TEXT . '`"]'],
]);
