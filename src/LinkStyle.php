<?php
/**
 * @copyright Copyright © 2023 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum LinkStyle: string
{
    case Dotted = '.';
    case Invisible = '~';
    case Solid = '-';
    case Thick = '=';
}
