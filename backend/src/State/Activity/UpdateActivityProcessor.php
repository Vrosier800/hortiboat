<?php

namespace App\State\Activity;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Activity\ActivityOutput;
use App\Dto\Activity\UpdateActivityInput;
use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<UpdateActivityInput, ActivityOutput>
 */
final class UpdateActivityProcessor implements ProcessorInterface {

    public function __construct(
        private readonly ActivityRepository $activityRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ActivityOutput {
        if (!$data instanceof UpdateActivityInput) {
            throw new \LogicException('UpdateActivityInput attendu.');
        }

        error_log('DESCRIPTION DTO = ' . var_export($data->description, true));

        $activity = $this->activityRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$activity) {
            throw new NotFoundHttpException('Activité non trouvée.');
        }

        if ($data->name !== null) {
            $activity->setName($data->name);
        }

        if ($data->slug !== null) {
            $activity->setSlug($data->slug);
        }

        if($data->description !==null) {
            $activity->setDescription($data->description);
        }

        if ($data->active !== null) {
            $activity->setActive($data->active);
        }

        $activity->setUpdatedAt(new \DateTimeImmutable());

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