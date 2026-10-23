<?php

namespace App\Dto\Activity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use App\Dto\Activity\UpdateActivityInput;
use App\Dto\Activity\ActivityInput;
use App\State\Activity\ActivityProcessor;
use App\State\Activity\ActivityProvider;
use App\State\Activity\UpdateActivityProcessor;

#[ApiResource(
    shortName: 'Activity',
    operations: [
        new GetCollection(
            uriTemplate:'/activities',
            provider: ActivityProvider::class,
        ),
        new Get(
            uriTemplate: '/activities/{id}',
            provider: ActivityProvider::class,
        ),
        new Post(
            uriTemplate: '/activities',
            input: ActivityInput::class,
            output: ActivityOutput::class,
            processor: ActivityProcessor::class,
        ),
        new Patch(
            uriTemplate: '/activities/{id}',
            input: UpdateActivityInput::class,
            output: ActivityOutput::class,
            processor: UpdateActivityProcessor::class,
            read: false,
        ),
    ],
)]
final class ActivityOutput {

    #[ApiProperty(identifier: true)]
    public int $id;

    public string $name;

    public string $slug;

    public ?string $description = null;

    public bool $active;

    public \DateTimeImmutable $createdAt;

    public ?\DateTimeImmutable $updatedAt = null;

};