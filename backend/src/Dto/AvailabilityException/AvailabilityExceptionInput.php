<?php

namespace App\Dto\AvailabilityException;

use Symfony\Component\Validator\Constraints as Assert;

final class AvailabilityExceptionInput {

    #[Assert\NotNull]
    public \DateTimeImmutable $startAt;

    #[Assert\NotNull]
    public \DateTimeImmutable $endAt;

    #[Assert\Choice(choices: ['OPEN', 'CLOSED'])]
    public string $type;

    #[Assert\Length(max: 255)]
    public ?string $reason =null;
}