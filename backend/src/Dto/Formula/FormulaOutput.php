<?php

namespace App\Dto\Formula;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\State\Formula\FormulaProvider;
use ApiPlatform\Metadata\Post;
use App\Dto\Formula\FormulaInput;
use App\State\Formula\FormulaProcessor;
use App\Dto\Formula\UpdateFormulaInput;
use App\State\Formula\UpdateFormulaProcessor;


#[ApiResource(
    shortName: 'Formula',
    operations: [
        new GetCollection(
            uriTemplate: '/formulas',
            provider: FormulaProvider::class,
        ),
        new Get(
            uriTemplate: '/formulas/{id}',
            provider: FormulaProvider::class,
        ),
        new Post(
            uriTemplate: '/formulas',
            input: FormulaInput::class,
            output: FormulaOutput::class,
            processor: FormulaProcessor::class,
        ),
        new Patch(
            uriTemplate: '/formulas',
            input: FormulaInput::class,
            output: FormulaOutput::class,
            processor: FormulaProcessor::class,
        ),
        new Patch(
            uriTemplate: '/formulas/{id}',
            input: UpdateFormulaInput::class,
            output:FormulaOutput::class,
            processor: UpdateFormulaProcessor::class,
            read: false,
        ),
    ],
)]
final class FormulaOutput
{
    #[ApiProperty(identifier: true)]
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