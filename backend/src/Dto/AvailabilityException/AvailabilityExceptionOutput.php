<?php

namespace App\Dto\AvailabilityException;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\State\AvailabilityException\AvailabilityExceptionProvider;
use ApiPlatform\Metadata\Post;
use App\Dto\AvailabilityException\AvailabilityExceptionInput;
use App\State\AvailabilityException\AvailabilityExceptionProcessor;
use ApiPlatform\Metadata\Patch;
use App\Dto\AvailabilityException\UpdateAvailabilityExceptionInput;
use App\State\AvailabilityException\UpdateAvailabilityExceptionProcessor;

#[ApiResource(
    shortName: 'AvailabilityException',
    operations: [
        new GetCollection(
            uriTemplate: '/availability-exceptions',
            provider: AvailabilityExceptionProvider::class,
        ),
        new Get(
            uriTemplate: '/availability-exceptions/{id}',
            provider: AvailabilityExceptionProvider::class,
        ),
        new Post(
            uriTemplate: '/availability-exceptions',
            input: AvailabilityExceptionInput::class,
            output: AvailabilityExceptionOutput::class,
            processor: AvailabilityExceptionProcessor::class,
        ),
        new Patch(
            uriTemplate: '/availability-exceptions/{id}',
            input: UpdateAvailabilityExceptionInput::class,
            output: AvailabilityExceptionOutput::class,
            processor: UpdateAvailabilityExceptionProcessor::class,
            read: false,
        ),
    ],
)]
final class AvailabilityExceptionOutput
{
    #[ApiProperty(identifier: true)]
    public int $id;

    public \DateTimeImmutable $startAt;

    public \DateTimeImmutable $endAt;

    public string $type;

    public ?string $reason = null;

    public \DateTimeImmutable $createdAt;
}