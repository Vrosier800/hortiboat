<?php

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\User\UserOutput;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @implements ProviderInterface<UserOutput>
 */
final class UserProvider implements ProviderInterface
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ?UserOutput {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedHttpException(
                'Utilisateur non authentifié.'
            );
        }

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