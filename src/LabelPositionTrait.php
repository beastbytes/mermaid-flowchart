<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

trait LabelPositionTrait
{
    private ?LabelPosition $position = null;

    public function withPosition(LabelPosition $position): self
    {
        $new = clone $this;
        $new->position = $position;
        return $new;
    }
}