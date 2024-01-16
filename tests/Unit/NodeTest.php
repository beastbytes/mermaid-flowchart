<?php

use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\NodeShape;
use BeastBytes\Mermaid\Mermaid;

defined('COMMENT') or define('COMMENT', 'Comment');
defined('TEXT') or define('TEXT', 'Text');
defined('MARKDOWN_TEXT') or define('MARKDOWN_TEXT', '*Markdown* Text');
defined('NODE_ID') or define('NODE_ID', 'node');
defined('STYLE_CLASS') or define('STYLE_CLASS', 'style_class');

test('Simple node', function () {
    $node = new Node(NODE_ID);

    expect($node->getId())
        ->toBe('_' . NODE_ID)
        ->and($node->render(''))
        ->toBe('_' . NODE_ID . '["' . NODE_ID . '"]')
    ;
});

test('Node with comment', function () {
    $node = (new Node(NODE_ID))
        ->withComment(COMMENT)
    ;

    expect($node->render(''))
        ->toBe(
            '%% ' . COMMENT . "\n"
            . '_' . NODE_ID . '["' . NODE_ID . '"]'
        )
    ;
});

test('Node shapes', function (NodeShape $shape, string $result) {
    $node = new Node(NODE_ID, $shape);

    expect($node->render(''))
        ->toBe($result)
    ;
})
    ->with('nodeShapes')
;

test('Node with text', function (string $text, bool $isMarkdown, string $result) {
    $node = (new Node(id: NODE_ID))
        ->withText($text, $isMarkdown)
    ;

    expect($node->render(''))
        ->toBe($result)
    ;
})
    ->with('text')
;

test('Node with styleClass', function () {
    $node = (new Node(NODE_ID))->withStyleClass(STYLE_CLASS);

    expect($node->render(''))
        ->toBe('_' . NODE_ID . ':::' . STYLE_CLASS  . '["' . NODE_ID . '"]')
    ;
});

test('Node with interaction', function () {
    $output = [];

    (new Node(NODE_ID))
        ->withInteraction('https://example.com')
        ->renderInteraction($output)
    ;

    expect($output[0])
        ->toBe('  click _' . NODE_ID . ' href "https://example.com" _self')
    ;
});

dataset('nodeShapes', [
    [NodeShape::Asymmetric, '_' . NODE_ID . '>"' . NODE_ID . '"]'],
    [NodeShape::Circle, '_' . NODE_ID . '(("' . NODE_ID . '"))'],
    [NodeShape::Cylinder, '_' . NODE_ID . '[("' . NODE_ID . '")]'],
    [NodeShape::DoubleCircle, '_' . NODE_ID . '((("' . NODE_ID . '")))'],
    [NodeShape::Hexagon, '_' . NODE_ID . '{{"' . NODE_ID . '"}}'],
    [NodeShape::Parallelogram, '_' . NODE_ID . '[/"' . NODE_ID . '"/]'],
    [NodeShape::ParallelogramAlt, '_' . NODE_ID . '[\\"' . NODE_ID . '"\\]'],
    [NodeShape::Rectangle, '_' . NODE_ID . '["' . NODE_ID . '"]'],
    [NodeShape::Rhombus, '_' . NODE_ID . '{"' . NODE_ID . '"}'],
    [NodeShape::Rounded, '_' . NODE_ID . '("' . NODE_ID . '")'],
    [NodeShape::Stadium, '_' . NODE_ID . '(["' . NODE_ID . '"])'],
    [NodeShape::Subroutine, '_' . NODE_ID . '[["' . NODE_ID . '"]]'],
    [NodeShape::Trapezoid, '_' . NODE_ID . '[/"' . NODE_ID . '"\\]'],
    [NodeShape::TrapezoidAlt, '_' . NODE_ID . '[\\"' . NODE_ID . '"/]'],
]);

dataset('text', [
    [TEXT, false, '_' . NODE_ID . '["' . TEXT . '"]'],
    [MARKDOWN_TEXT, true, '_' . NODE_ID . '["`' . MARKDOWN_TEXT . '`"]'],
]);
