<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\User\UpdateUserInput;
use App\Dto\User\UserOutput;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * @implements ProcessorInterface<UpdateUserInput, UserOutput>
 */
final class UpdateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): UserOutput {
        if (!$data instanceof UpdateUserInput) {
            throw new \LogicException('UpdateUserInput attendu.');
        }

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedHttpException(
                'Utilisateur non authentifié.'
            );
        }

        if ($data->email !== null) {
            $email = strtolower(trim($data->email));

            $existingUser = $this->userRepository->findOneBy([
                'email' => $email,
            ]);

            if (
                $existingUser !== null
                && $existingUser->getId() !== $user->getId()
            ) {
                throw new ConflictHttpException(
                    'Un compte existe déjà avec cette adresse e-mail.'
                );
            }

            $user->setEmail($email);
        }

        if ($data->firstName !== null) {
            $user->setFirstName($data->firstName);
        }

        if ($data->lastName !== null) {
            $user->setLastName($data->lastName);
        }

        if ($data->phone !== null) {
            $user->setPhone($data->phone);
        }

        $user->setUpdatedAt(new \DateTimeImmutable());

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