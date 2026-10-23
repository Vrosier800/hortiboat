<?php

namespace App\State\Activity;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Activity\ActivityOutput;
use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @implements ProviderInterFace<ActivityOutput|ActivityOutput[]>
 */
final class ActivityProvider implements ProviderInterface {

    public function __construct(
        private readonly ActivityRepository $activityRepository,
    ){}

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ActivityOutput|array|null {
        if ($operation instanceof CollectionOperationInterface) {
            return array_map (
                fn (Activity $activity) => $this->toOutput($activity),
                $this->activityRepository->findAll(),
            );
    }

    $activity = $this->activityRepository->find($uriVariables['id'] ?? null);

    if (!$activity) {
        throw new NotFoundHttpException('Activité non trouvée');
    }

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