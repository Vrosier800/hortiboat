<?php

namespace App\Dto\OpeningRule;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\State\OpeningRule\OpeningRuleProvider;
use ApiPlatform\Metadata\Post;
use App\Dto\OpeningRule\OpeningRuleInput;
use App\State\OpeningRule\OpeningRuleProcessor;
use ApiPlatform\Metadata\Patch;
use App\Dto\OpeningRule\UpdateOpeningRuleInput;
use App\State\OpeningRule\UpdateOpeningRuleProcessor;

#[ApiResource(
    shortName: 'OpeningRule',
    operations: [
        new GetCollection(
            uriTemplate: '/opening-rules',
            provider: OpeningRuleProvider::class,
        ),
        new Get(
            uriTemplate: '/opening-rules/{id}',
            provider: OpeningRuleProvider::class,
        ),
        new Post(
            uriTemplate: '/opening-rules',
            input: OpeningRuleInput::class,
            output: OpeningRuleOutput::class,
            processor: OpeningRuleProcessor::class,
        ),
        new Patch(
            uriTemplate: '/opening-rules/{id}',
            input: UpdateOpeningRuleInput::class,
            output: OpeningRuleOutput::class,
            processor: UpdateOpeningRuleProcessor::class,
            read: false,
        ),
    ],
)]
final class OpeningRuleOutput
{
    #[ApiProperty(identifier: true)]
    public int $id;

    public int $dayOfWeek;

    public \DateTimeImmutable $startTime;

    public \DateTimeImmutable $endTime;

    public ?\DateTimeImmutable $validFrom = null;

    public ?\DateTimeImmutable $validUntil = null;

    public bool $active;

    public \DateTimeImmutable $createdAt;
}