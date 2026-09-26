<?php 

namespace App\Dto\AvailabilityExeption;

final class AvailabilityExeptionOutput {

    public int $id;

    public \DateTimeImmutable $startAt;

    public \DateTimeImmutable $endAt;

    public string $type;

    public ?string $reason = null;

    public \DateTimeImmutable $createdAt;

};