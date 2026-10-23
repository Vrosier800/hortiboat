<?php

namespace App\State\OpeningRule;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\OpeningRule\OpeningRuleOutput;
use App\Entity\OpeningRule;
use App\Repository\OpeningRuleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProviderInterface<OpeningRuleOutput|OpeningRuleOutput[]>
 */
final class OpeningRuleProvider implements ProviderInterface
{
    public function __construct(
        private readonly OpeningRuleRepository $openingRuleRepository,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): OpeningRuleOutput|array|null {
        if ($operation instanceof CollectionOperationInterface) {
            return array_map(
                fn (OpeningRule $openingRule) => $this->toOutput($openingRule),
                $this->openingRuleRepository->findAll(),
            );
        }

        $openingRule = $this->openingRuleRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$openingRule) {
            throw new NotFoundHttpException('Règle d’ouverture non trouvée.');
        }

        return $this->toOutput($openingRule);
    }

    private function toOutput(OpeningRule $openingRule): OpeningRuleOutput
    {
        $output = new OpeningRuleOutput();

        $output->id = $openingRule->getId();
        $output->dayOfWeek = $openingRule->getDayOfWeek();
        $output->startTime = $openingRule->getStartTime();
        $output->endTime = $openingRule->getEndTime();
        $output->validFrom = $openingRule->getValidFrom();
        $output->validUntil = $openingRule->getValidUntil();
        $output->active = $openingRule->isActive();
        $output->createdAt = $openingRule->getCreatedAt();

        return $output;
    }
}