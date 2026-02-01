<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

use BeastBytes\Mermaid\IdTrait;

final class EdgeId
{
    use IdTrait;

    private const string EDGE_ID = '%s@%s';

    public function __construct(?string $id = null, private readonly array $properties = [])
    {
        $this->id = $id;
    }

    public function render(): string
    {
        return sprintf(
            self::EDGE_ID,
            $this->getId(),
            !empty($this->properties) ? json_encode($this->properties, JSON_FORCE_OBJECT) : ''
        );
    }
}