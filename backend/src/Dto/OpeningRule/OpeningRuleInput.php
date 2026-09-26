<?php

namespace App\Dto\OpeningRule;

use Symfony\Component\Validator\Constraints as Assert;

final class OpeningRuleInput {

    #[Assert\Range(min: 1, max: 7)]
    public int $dayOfWeek;

    #[Assert\NotNull]
    public \DateTimeImmutable $startTime;

    #[Assert\NotNull]
    public \DateTimeImmutable $endTime;

    public ?\DateTimeImmutable $validFrom = null;

    public ?\DateTimeImmutable $validUntil = null;

    public bool $active = true;
}