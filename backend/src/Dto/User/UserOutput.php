<?php

namespace App\Dto\User;

final class UserOutput {

    public int $id;

    public string $email;

    public string $firstName;

    public string $lastName;

    public string $phone;

    public array $roles = [];

    public bool $isVerified;

    public \DateTimeImmutable $createdAt;

    public ?\DateTimeImmutable $updatedAt = null;
}