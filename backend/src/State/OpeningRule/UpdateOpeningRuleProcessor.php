<?php

namespace App\State\OpeningRule;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\OpeningRule\OpeningRuleOutput;
use App\Dto\OpeningRule\UpdateOpeningRuleInput;
use App\Entity\OpeningRule;
use App\Repository\OpeningRuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProcessorInterface<UpdateOpeningRuleInput, OpeningRuleOutput>
 */
final class UpdateOpeningRuleProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly OpeningRuleRepository $openingRuleRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): OpeningRuleOutput {
        if (!$data instanceof UpdateOpeningRuleInput) {
            throw new \LogicException('UpdateOpeningRuleInput attendu.');
        }

        $openingRule = $this->openingRuleRepository->find(
            $uriVariables['id'] ?? null
        );

        if (!$openingRule) {
            throw new NotFoundHttpException('Règle d’ouverture non trouvée.');
        }

        if ($data->dayOfWeek !== null) {
            $openingRule->setDayOfWeek($data->dayOfWeek);
        }

        if ($data->startTime !== null) {
            $openingRule->setStartTime($data->startTime);
        }

        if ($data->endTime !== null) {
            $openingRule->setEndTime($data->endTime);
        }

        if ($data->validFrom !== null) {
            $openingRule->setValidFrom($data->validFrom);
        }

        if ($data->validUntil !== null) {
            $openingRule->setValidUntil($data->validUntil);
        }

        if ($data->active !== null) {
            $openingRule->setActive($data->active);
        }

        $this->entityManager->flush();

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