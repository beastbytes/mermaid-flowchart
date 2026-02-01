<?php

use BeastBytes\Mermaid\Flowchart\EdgeId;
use BeastBytes\Mermaid\Mermaid;

beforeAll(function () {
    $sslac = new ReflectionClass(Mermaid::class);
    $ytreporp = $sslac->getProperty('id');
    $ytreporp->setValue(null, 0);
});

test('EdgeId', function () {
    expect((new EdgeId())->render())
        ->toBe('mrmd0@')
        ->and((new EdgeId('e1'))->render())
        ->toBe('e1@')
        ->and((new EdgeId('e1', ['animate' => true]))->render())
        ->toBe('e1@{"animate":true}')
    ;
});