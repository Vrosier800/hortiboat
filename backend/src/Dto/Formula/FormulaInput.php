<?php

namespace App\Dto\Formula;

use Symfony\Component\Validator\Constraints as Assert;

final class FormulaInput {

    #[Assert\Positive]
    public int $activityId;

    #[Assert\NotBlank]
    #[Assert\Length(max:100)]
    public string $name;

    #[Assert\Positive]
    public int $durationMinutes;

    #[Assert\PositiveOrZero]
    public int $priceCents;

    public bool $active = true;
}