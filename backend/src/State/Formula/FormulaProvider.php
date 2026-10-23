<?php

namespace App\State\Formula;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\Formula\FormulaOutput;
use App\Entity\Formula;
use App\Repository\FormulaRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProviderInterface<FormulaOutput|FormulaOutput[]>
 */
final class FormulaProvider implements ProviderInterface
{
    public function __construct(
        private readonly FormulaRepository $formulaRepository,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): FormulaOutput|array|null {
        if ($operation instanceof CollectionOperationInterface) {
            return array_map(
                fn (Formula $formula) => $this->toOutput($formula),
                $this->formulaRepository->findAll(),
            );
        }

        $formula = $this->formulaRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$formula) {
            throw new NotFoundHttpException('Formule non trouvée.');
        }

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