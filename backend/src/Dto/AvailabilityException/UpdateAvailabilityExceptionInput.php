<?php

namespace App\Dto\AvailabilityException;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateAvailabilityExceptionInput
{
    public ?\DateTimeImmutable $startAt = null;

    public ?\DateTimeImmutable $endAt = null;

    #[Assert\Choice(choices: ['OPEN', 'CLOSED'])]
    public ?string $type = null;

    #[Assert\Length(max: 255)]
    public ?string $reason = null;
}