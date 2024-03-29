<?php

namespace KPZadatak\Core\Services\Contracts;

interface MailerInterface
{
    /**
     * Sends an email.
     *
     * @param string $to The recipient's email address.
     * @param string $subject The subject of the email.
     * @param string $message The body of the email.
     * @param string $headers The headers for the email.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function send(string $to, string $subject, string $message, string $headers): bool;
}
