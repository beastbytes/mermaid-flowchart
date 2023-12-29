<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum ArrowHead: string
{
    case Default = '>';
    case None = '';
    case O = 'o';
    case X = 'x';
}
