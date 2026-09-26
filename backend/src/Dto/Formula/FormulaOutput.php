<?php

namespace App\Dto\Formula;

final class FormulaOutpout {

    public int $id;

    public int $activityId;

    public string $activityName;

    public string $name;

    public int $durationMinutes;

    public int $priceCents;

    public bool $active;

    public \DateTimeImmutable $createdAt;

    public ?\DateTimeImmutable $updatedAt = null;
}