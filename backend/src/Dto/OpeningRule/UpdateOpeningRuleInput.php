<?php

namespace App\Dto\OpeningRule;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateOpeningRuleInput
{
    #[Assert\Range(min: 1, max: 7)]
    public ?int $dayOfWeek = null;

    public ?\DateTimeImmutable $startTime = null;

    public ?\DateTimeImmutable $endTime = null;

    public ?\DateTimeImmutable $validFrom = null;

    public ?\DateTimeImmutable $validUntil = null;

    public ?bool $active = null;
}