<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum Direction
{
    case BT;
    case LR;
    case RL;
    case TB;
    case TD;
}
