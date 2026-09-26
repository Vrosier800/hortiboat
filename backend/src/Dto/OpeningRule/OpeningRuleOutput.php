<?php

namespace App\Dto\OpeningRule;

final class OpeningRuleOutput {

    public int $id;

    public int $dayOfWeek;

    public \DateTimeImmutable $startTime;

    public \DateTimeImmutable $endTime;

    public ?\DateTimeImmutable $validFrom = null;

    public ?\DateTimeImmutable $validUntil = null;

    public bool $active;

    public \DateTimeImmutable $createdAt;
}