<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum EdgeStyle: string
{
    case dotted = '.';
    case invisible = '~';
    case solid = '-';
    case thick = '=';
}