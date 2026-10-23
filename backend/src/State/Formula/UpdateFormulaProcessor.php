<?php

namespace App\State\Formula;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Formula\FormulaOutput;
use App\Dto\Formula\UpdateFormulaInput;
use App\Entity\Formula;
use App\Repository\ActivityRepository;
use App\Repository\FormulaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<UpdateFormulaInput, FormulaOutput>
 */
final class UpdateFormulaProcessor implements ProcessorInterface {

    public function __construct(
        private readonly FormulaRepository $formulaRepository,
        private readonly ActivityRepository $activityRepository,
        private readonly EntityManagerInterface $entityManager,
    ){}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): FormulaOutput {
        if (!$data instanceof UpdateFormulaInput){
            throw new \LogicException('UpdateFormulaInput attendu');
        }

        $formula = $this->formulaRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$formula) {
            throw new NotFoundHttpException('Formule non trouvée');
        }

        if ($data->activityId !== null) {
            $activity = $this->activityRepository->find($data->activityId);

            if (!$activity) {
                throw new NotFoundHttpException('Activité non trouvée.');
            }

            $formula->setActivity($activity);
        }

        if ($data->name !== null) {
            $formula->setName($data->name);
        }

        if ($data->durationMinutes !== null) {
            $formula->setDurationMinutes($data->durationMinutes);
        }

        if ($data->priceCents !== null) {
            $formula->setPriceCents($data->priceCents);
        }

        if ($data->active !== null) {
            $formula->setActive($data->active);
        }

        $formula->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $this->toOutput($formula);
    }

    private function toOutput(Formula $formula): FormulaOutput {
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