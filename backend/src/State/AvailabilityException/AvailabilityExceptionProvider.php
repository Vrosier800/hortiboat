<?php

namespace App\State\AvailabilityException;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AvailabilityException\AvailabilityExceptionOutput;
use App\Entity\AvailabilityException;
use App\Repository\AvailabilityExceptionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProviderInterface<AvailabilityExceptionOutput|AvailabilityExceptionOutput[]>
 */
final class AvailabilityExceptionProvider implements ProviderInterface
{
    public function __construct(
        private readonly AvailabilityExceptionRepository $availabilityExceptionRepository,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): AvailabilityExceptionOutput|array|null {
        if ($operation instanceof CollectionOperationInterface) {
            return array_map(
                fn (AvailabilityException $exception) => $this->toOutput($exception),
                $this->availabilityExceptionRepository->findAll(),
            );
        }

        $exception = $this->availabilityExceptionRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$exception) {
            throw new NotFoundHttpException(
                'Exception de disponibilité non trouvée.'
            );
        }

        return $this->toOutput($exception);
    }

    private function toOutput(
        AvailabilityException $exception
    ): AvailabilityExceptionOutput {
        $output = new AvailabilityExceptionOutput();

        $output->id = $exception->getId();
        $output->startAt = $exception->getStartAt();
        $output->endAt = $exception->getEndAt();
        $output->type = $exception->getType();
        $output->reason = $exception->getReason();
        $output->createdAt = $exception->getCreatedAt();

        return $output;
    }
}