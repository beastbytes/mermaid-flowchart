<?php

use BeastBytes\Mermaid\Flowchart\IconNode;
use BeastBytes\Mermaid\Flowchart\IconShape;
use BeastBytes\Mermaid\Flowchart\ImageNode;
use BeastBytes\Mermaid\Flowchart\LabelPosition;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\NodeShape;
use BeastBytes\Mermaid\InteractionType;

defined('COMMENT') or define('COMMENT', 'Comment');
defined('TEXT') or define('TEXT', 'Text');
defined('MARKDOWN_TEXT') or define('MARKDOWN_TEXT', '*Markdown* Text');
defined('NODE_ID') or define('NODE_ID', 'nodeId');
defined('STYLE_CLASS') or define('STYLE_CLASS', 'style_class');

test('Simple node', function () {
    $node = (new Node(id: NODE_ID))
        ->withText(TEXT);

    expect($node->getId())
        ->toBe('nodeId')
        ->and($node->render(''))
        ->toBe('nodeId@{"shape":"process","label":"Text"}')
    ;
});

test('Node with comment', function () {
    $node = (new Node(id:NODE_ID))
        ->withComment(COMMENT)
        ->withText(TEXT)
    ;

    expect($node->render(''))
        ->toBe(<<<EXPECTED
%% Comment
nodeId@{"shape":"process","label":"Text"}
EXPECTED
        )
    ;
});

test('Node shapes', function (NodeShape $shape) {
    $id = md5($shape->value);

    expect((new Node($shape, $id))
        ->withText($shape->name)
        ->render('')
    )
        ->toBe(sprintf('%s@{"shape":"%s","label":"%s"}', $id, $shape->value, $shape->name))
    ;
})
    ->with('nodeShapes')
;

test('Icon Node', function (
    string $icon,
    ?IconShape $shape = null,
    ?string $label = null,
    ?LabelPosition $position = null,
    ?int $height = null
) {
    $id = md5($icon);
    $node = new IconNode($icon, $id);
    $node = $shape ? $node->withShape($shape) : $node;
    $node = $label ? $node->withText($label) : $node;
    $node = $position ? $node->withPosition($position) : $node;
    $node = $height ? $node->withHeight($height) : $node;

    $config = compact('icon');
    if ($shape) {
        $config['form'] = $shape->name;
    }
    if ($label) {
        $config['label'] = $label;
    }
    if ($position) {
        $config['pos'] = $position->value;
    }
    if ($height) {
        $config['h'] = $height;
    }

    expect($node->render(''))
        ->toBe(sprintf('%s@%s', $id, json_encode($config)))
    ;
})
    ->with('icons')
;

test('ImageNode', function (
    string $url,
    ?string $label = null,
    ?LabelPosition $position = null,
    ?int $height = null,
    ?int $width = null
) {
    $id = md5($url);
    $node = new ImageNode($url, $id);
    $node = $label ? $node->withText($label) : $node;
    $node = $position ? $node->withPosition($position) : $node;
    $node = $height ? $node->withSize($height, $width) : $node;

    $config['img'] = $url;
    if ($label) {
        $config['label'] = $label;
    }
    if ($position) {
        $config['pos'] = $position->value;
    }
    if ($height) {
        $config['h'] = $height;
    }
    if ($width) {
        $config['w'] = $width;
    }
    $config['constraint'] = $height && !$width ? 'on' : 'off';

    expect($node->render(''))
        ->toBe(sprintf('%s@%s', $id, json_encode($config)))
    ;
})
    ->with('images')
;

test('Node with text', function (string $text, bool $isMarkdown, string $result) {
    expect((new Node(id: NODE_ID))
        ->withText($text, $isMarkdown)
        ->render('')
    )
        ->toBe($result)
    ;
})
    ->with('text')
;

test('Node with styleClass', function () {
    expect((new Node(id: NODE_ID))
        ->withStyleClass(STYLE_CLASS)
        ->withText(TEXT)
        ->render('')
    )
        ->toBe('nodeId:::' . STYLE_CLASS  . '@{"shape":"process","label":"Text"}')
    ;
});

test('Node with interaction', function () {
    expect((new Node(id:NODE_ID))
        ->withInteraction('https://example.com', InteractionType::Link)
        ->renderInteraction())
        ->toBe('  click nodeId href "https://example.com" _self')
    ;
});

dataset('icons', [
    'fa:user' => [
        'icon' => 'fa:user',
        'shape' => IconShape::circle,
        'label' => 'User',
        'position' => LabelPosition::top,
        'height' => 64
    ],
    'fa:eye' => [
        'icon' => 'fa:eye',
        'shape' => IconShape::rounded,
        'label' => 'View',
        'position' => null,
        'height' => 48
    ],
    'fa:bomb' => [
        'icon' => 'fa:bomb',
        'shape' => IconShape::circle,
        'label' => 'Delete',
        'position' => LabelPosition::bottom,
        'height' => null
    ],
    'fa:car' => [
        'icon' => 'fa:car',
        'shape' => IconShape::square,
        'label' => 'Leave',
        'position' => null,
        'height' => null
    ],
    'fa:bookmark' => [
        'icon' => 'fa:bookmark',
        'shape' => null,
        'label' => null,
        'position' => null,
        'height' => null
    ],
]);

dataset('images', [
    '0' => [
        'url' => 'https://example.com/test-image0.jpg',
        'label' => 'Label 0',
        'position' => LabelPosition::top,
        'height' => 48,
        'width' => 52
    ],
    '1' => [
        'url' => 'https://example.com/test-image1.jpg',
        'label' => 'Label 1',
        'position' => LabelPosition::top,
        'height' => 48
    ],
    '2' => [
        'url' => 'https://example.com/test-image2.jpg',
        'label' => 'Label 2',
        'position' => LabelPosition::bottom
    ],
    '3' => [
        'url' => 'https://example.com/test-image3.jpg',
        'label' => 'Label 3'
    ],
    '4' => [
        'url' => 'https://example.com/test-image4.jpg',
        'label' => 'Label 0',
        'position' => LabelPosition::top,
        'height' => 48,
        'width' => 52,
    ],
    '5' => [
        'url' => 'https://example.com/test-image5.jpg'
    ],
    '6' => [
        'url' => 'https://example.com/test-image6.jpg',
        'height' => 48,
    ],
]);

dataset('nodeShapes', NodeShape::cases());

dataset('text', [
    [TEXT, false, 'nodeId@{"shape":"process","label":"Text"}'],
    [MARKDOWN_TEXT, true, 'nodeId@{"shape":"process","label":"`*Markdown* Text`"}'],
]);