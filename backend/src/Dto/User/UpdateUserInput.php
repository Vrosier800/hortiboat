<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateUserInput
{
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    public ?string $email = null;

    #[Assert\Length(max: 100)]
    public ?string $firstName = null;

    #[Assert\Length(max: 100)]
    public ?string $lastName = null;

    #[Assert\Length(max: 20)]
    public ?string $phone = null;
}