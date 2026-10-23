<?php

namespace App\Dto\User;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Dto\User\RegisterUserInput;
use App\State\User\RegisterUserProcessor;
use ApiPlatform\Metadata\Get;
use App\State\User\UserProvider;
use ApiPlatform\Metadata\Patch;
use App\Dto\User\UpdateUserInput;
use App\State\User\UpdateUserProcessor;

#[ApiResource(
    shortName: 'User',
    operations: [
        new Post(
            uriTemplate: '/register',
            input: RegisterUserInput::class,
            output: UserOutput::class,
            processor: RegisterUserProcessor::class,
        ),
        new Get(
            uriTemplate: '/me',
            provider: UserProvider::class,
        ),
        new Patch(
            uriTemplate: '/me',
            input: UpdateUserInput::class,
            output: UserOutput::class,
            processor: UpdateUserProcessor::class,
            read: false,
        ),
    ],
)]
final class UserOutput
{
    #[ApiProperty(identifier: true)]
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