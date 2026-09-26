<?php

namespace App\Dto\Activity;

use Symfony\Component\Validator\Constraints as Assert;

final class ActivityInput
{
    #[Assert\NotBlank]
    #[Assert\Length(max:10)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(max:100)]
    public string $slug;

    public ?string $description = null;

    public bool $active = true;
};