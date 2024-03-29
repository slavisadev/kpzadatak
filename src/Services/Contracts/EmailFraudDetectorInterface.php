<?php

namespace KPZadatak\Services\Contracts;

interface EmailFraudDetectorInterface
{
    public function isFraudulent(string $email): bool;
}
