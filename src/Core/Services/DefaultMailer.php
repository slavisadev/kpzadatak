<?php

namespace KPZadatak\Core\Services;

use KPZadatak\Core\Services\Contracts\MailerInterface;

class DefaultMailer implements MailerInterface
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $headers
     *
     * @return bool
     */
    public function send(string $to, string $subject, string $message, string $headers): bool
    {
        return mail($to, $subject, $message, $headers);
    }
}
