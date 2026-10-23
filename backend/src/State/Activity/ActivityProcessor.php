<?php

namespace App\State\Activity;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Activity\ActivityInput;
use App\Dto\Activity\ActivityOutput;
use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements ProcessorInterface<ActivityInput, ActivityOutput>
 */
final class ActivityProcessor implements ProcessorInterface {

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ActivityOutput {
        if (!$data instanceof ActivityInput) {
            throw new \LogicException('ActivityInput attendu.');
        }

        $activity = new Activity();

        $activity->setName($data->name);
        $activity->setSlug($data->slug);
        $activity->setDescription($data->description);
        $activity->setActive($data->active);
        $activity->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        return $this->toOutput($activity);
    }

    private function toOutput(Activity $activity): ActivityOutput {
        $output = new ActivityOutput();

        $output->id = $activity->getId();
        $output->name = $activity->getName();
        $output->slug = $activity->getSlug();
        $output->description = $activity->getDescription();
        $output->active = $activity->isActive();
        $output->createdAt = $activity->getCreatedAt();
        $output->updatedAt = $activity->getUpdatedAt();

        return $output;
    }
}