<?php

namespace App\Dto\Formula;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateFormulaInput {

    #[Assert\Positive]
    public ?int $activityId = null;

    #[Assert\Length(max: 100)]
    public ?string $name = null;

    #[Assert\Positive]
    public ?int $durationMinutes = null;

    #[Assert\PositiveOrZero]
    public ?int $priceCents = null;

    public ?bool $active = null;
}