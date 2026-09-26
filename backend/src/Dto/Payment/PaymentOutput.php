<?php

namespace App\Dto\Payment;

final class PaymentOutput {

    public int $id;
    
    public int $reservationId;

    public string $method;

    public string $status;

    public int $amountCents;

    public ?string $provider = null;

    public ?string $providerPaymentId = null;

    public \DateTimeImmutable $createdAt;

    public ?\DateTimeImmutable $paidAt = null;

    public ?\DateTimeImmutable $refundedAt = null;
}