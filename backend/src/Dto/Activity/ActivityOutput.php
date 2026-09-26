<?php

namespace App\Dto\Activity;

final class ActivityOutput {

    public int $id;

    public string $name;

    public string $slug;

    public ?string $description = null;

    public bool $active;

    public \DateTimeImmutable $createdAt;

    public ?\DateTimeImmutable $updatedAt = null;

};