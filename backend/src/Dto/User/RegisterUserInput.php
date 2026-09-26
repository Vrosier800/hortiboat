<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserInput {

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 255)]
    public string $plainPassword;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $firstName;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $lastName;

    #[Assert\Length(max: 20)]
    public string $phone;
}