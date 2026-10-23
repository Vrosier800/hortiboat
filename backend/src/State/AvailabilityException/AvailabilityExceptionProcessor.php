<?php

namespace App\State\AvailabilityException;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\AvailabilityException\AvailabilityExceptionInput;
use App\Dto\AvailabilityException\AvailabilityExceptionOutput;
use App\Entity\AvailabilityException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements ProcessorInterface<AvailabilityExceptionInput, AvailabilityExceptionOutput>
 */
final class AvailabilityExceptionProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): AvailabilityExceptionOutput {
        if (!$data instanceof AvailabilityExceptionInput) {
            throw new \LogicException('AvailabilityExceptionInput attendu.');
        }

        $exception = new AvailabilityException();

        $exception->setStartAt($data->startAt);
        $exception->setEndAt($data->endAt);
        $exception->setType($data->type);
        $exception->setReason($data->reason);
        $exception->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($exception);
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