<?php

namespace App\State\Formula;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Formula\FormulaInput;
use App\Dto\Formula\FormulaOutput;
use App\Entity\Formula;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<FormulaInput, FormulaOutput>
 */
final class FormulaProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ActivityRepository $activityRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): FormulaOutput {
        if (!$data instanceof FormulaInput) {
            throw new \LogicException('FormulaInput attendu.');
        }

        $activity = $this->activityRepository->find($data->activityId);

        if (!$activity) {
            throw new NotFoundHttpException('Activité non trouvée.');
        }

        $formula = new Formula();

        $formula->setActivity($activity);
        $formula->setName($data->name);
        $formula->setDurationMinutes($data->durationMinutes);
        $formula->setPriceCents($data->priceCents);
        $formula->setActive($data->active);
        $formula->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($formula);
        $this->entityManager->flush();

        return $this->toOutput($formula);
    }

    private function toOutput(Formula $formula): FormulaOutput
    {
        $output = new FormulaOutput();

        $output->id = $formula->getId();
        $output->activityId = $formula->getActivity()->getId();
        $output->activityName = $formula->getActivity()->getName();
        $output->name = $formula->getName();
        $output->durationMinutes = $formula->getDurationMinutes();
        $output->priceCents = $formula->getPriceCents();
        $output->active = $formula->isActive();
        $output->createdAt = $formula->getCreatedAt();
        $output->updatedAt = $formula->getUpdatedAt();

        return $output;
    }
}