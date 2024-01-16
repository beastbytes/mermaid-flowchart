<?php
/**
 * @copyright Copyright © 2024 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum NodeShape: string
{
    case Asymmetric = '>%s]';
    case Circle = '((%s))';
    case Cylinder = '[(%s)]';
    case DoubleCircle = '(((%s)))';
    case Hexagon = '{{%s}}';
    case Rhombus = '{%s}';
    case Rectangle = '[%s]';
    case Rounded = '(%s)';
    case Parallelogram = '[/%s/]';
    case ParallelogramAlt = '[\\%s\\]';
    case Stadium = '([%s])';
    case Subroutine = '[[%s]]';
    case Trapezoid = '[/%s\\]';
    case TrapezoidAlt = '[\\%s/]';
}
