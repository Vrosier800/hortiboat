<?php

namespace App\Dto\Reservation;

final class ReservationOutpout {

    public int $id;

    public int $customerId;

    public int $customerFirstName;

    public string $customerLastName;

    public int $formulaId;

    public string $formulaName;

    public string $activityName;

    public \DateTimeImmutable $startAt;

    public \DateTimeImmutable $endAt;

    public int $participants;

    public string $status;

    public string $paymentMethod;

    public int $totalPriceCents;

    public \DateTimeImmutable $createdAt;

    public ?\DateTimeImmutable $updatedAt = null;

    public ?\DateTimeImmutable $cancelletAt = null;
}