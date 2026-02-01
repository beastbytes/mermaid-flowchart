<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum Arrowhead: string
{
    case arrow = '>';
    case circle = 'o';
    case cross = 'x';
    case open = '';
}