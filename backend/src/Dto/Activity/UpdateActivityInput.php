<?php

namespace App\Dto\Activity;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateActivityInput {

    #[Assert\Length(max: 100)]
    public ?string $name = null;

    #[Assert\Length(max: 100)]
    public ?string $slug = null;

    public ?string $description = null;

    public ?bool $active = null;
}