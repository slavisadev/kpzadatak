<?php

namespace KPZadatak\Services\Mocks;

use KPZadatak\Services\Contracts\EmailFraudDetectorInterface;

class MaxMind implements EmailFraudDetectorInterface
{

    private bool $shouldPass;

    public function __construct(bool $shouldPass)
    {
        $this->shouldPass = $shouldPass;
    }

    public function isFraudulent(string $email): bool
    {
        return !$this->shouldPass;
    }
}
