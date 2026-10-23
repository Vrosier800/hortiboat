<?php

namespace App\State\AvailabilityException;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\AvailabilityException\AvailabilityExceptionOutput;
use App\Dto\AvailabilityException\UpdateAvailabilityExceptionInput;
use App\Entity\AvailabilityException;
use App\Repository\AvailabilityExceptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<UpdateAvailabilityExceptionInput, AvailabilityExceptionOutput>
 */
final class UpdateAvailabilityExceptionProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly AvailabilityExceptionRepository $availabilityExceptionRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): AvailabilityExceptionOutput {
        if (!$data instanceof UpdateAvailabilityExceptionInput) {
            throw new \LogicException('UpdateAvailabilityExceptionInput attendu.');
        }

        $exception = $this->availabilityExceptionRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$exception) {
            throw new NotFoundHttpException(
                'Exception de disponibilité non trouvée.'
            );
        }

        if ($data->startAt !== null) {
            $exception->setStartAt($data->startAt);
        }

        if ($data->endAt !== null) {
            $exception->setEndAt($data->endAt);
        }

        if ($data->type !== null) {
            $exception->setType($data->type);
        }

        if ($data->reason !== null) {
            $exception->setReason($data->reason);
        }

        $this->entityManager->flush();

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