<?php

namespace App\Dto\Reservation;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateReservationInput {

    #[Assert\Positive]
    public int $formulaId;

    #[Assert\NotNull]
    #[Assert\GreaterThan('now')]
    public \DateTimeImmutable $startAt;

    #[Assert\Range(min: 1, max:5)]
    public int $participants;

    #[Assert\Choice(choices: ['ONLINE', 'ONSITE'])]
    public string $paymentMethod;
};