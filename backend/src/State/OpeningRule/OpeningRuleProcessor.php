<?php

namespace App\State\OpeningRule;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\OpeningRule\OpeningRuleInput;
use App\Dto\OpeningRule\OpeningRuleOutput;
use App\Entity\OpeningRule;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements ProcessorInterface<OpeningRuleInput, OpeningRuleOutput>
 */
final class OpeningRuleProcessor implements ProcessorInterface
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
    ): OpeningRuleOutput {
        if (!$data instanceof OpeningRuleInput) {
            throw new \LogicException('OpeningRuleInput attendu.');
        }

        $openingRule = new OpeningRule();

        $openingRule->setDayOfWeek($data->dayOfWeek);
        $openingRule->setStartTime($data->startTime);
        $openingRule->setEndTime($data->endTime);
        $openingRule->setValidFrom($data->validFrom);
        $openingRule->setValidUntil($data->validUntil);
        $openingRule->setActive($data->active);
        $openingRule->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($openingRule);
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