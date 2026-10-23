<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\User\RegisterUserInput;
use App\Dto\User\UserOutput;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @implements ProcessorInterface<RegisterUserInput, UserOutput>
 */
final class RegisterUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): UserOutput {
        if (!$data instanceof RegisterUserInput) {
            throw new \LogicException('RegisterUserInput attendu.');
        }

        $email = strtolower(trim($data->email));

        if ($this->userRepository->findOneBy(['email' => $email])) {
            throw new ConflictHttpException(
                'Un compte existe déjà avec cette adresse e-mail.'
            );
        }

        $user = new User();

        $user->setEmail($email);
        $user->setFirstName($data->firstName);
        $user->setLastName($data->lastName);
        $user->setPhone($data->phone);
        $user->setIsVerified(false);
        $user->setCreatedAt(new \DateTimeImmutable());

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $data->plainPassword
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->toOutput($user);
    }

    private function toOutput(User $user): UserOutput
    {
        $output = new UserOutput();

        $output->id = $user->getId();
        $output->email = $user->getEmail();
        $output->firstName = $user->getFirstName();
        $output->lastName = $user->getLastName();
        $output->phone = $user->getPhone();
        $output->roles = $user->getRoles();
        $output->isVerified = $user->isVerified();
        $output->createdAt = $user->getCreatedAt();
        $output->updatedAt = $user->getUpdatedAt();

        return $output;
    }
}