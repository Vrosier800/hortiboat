<?php

namespace App\Dto\AvailabilityExeption;

use Symfony\Component\Validator\Constraints as Assert;

final class AvailabilityExeptionInput {

    #[Assert\NotNull]
    public \DateTimeImmutable $startAt;

    #[Assert\NotNull]
    public \DateTimeImmutable $endAt;

    #[Assert\Choice(choices: ['OPEN', 'CLOSED'])]

    #[Assert\Length(max: 255)]
    public ?string $reason =null;
}