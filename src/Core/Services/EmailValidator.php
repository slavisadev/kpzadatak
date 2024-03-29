<?php

namespace KPZadatak\Core\Services;

class EmailValidator
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        return $this->validateLocalPartLength($email) &&
            $this->validateConsecutiveChars($email) &&
            $this->validateDomainPresence($email) &&
            $this->validateLocalPart($email) &&
            $this->validateDomain($email);
    }

    private function validateLocalPartLength(string $email): bool
    {
        $localPart = $this->extractLocalPart($email);
        return strlen($localPart) <= 255;
    }

    private function validateConsecutiveChars(string $email): bool
    {
        $localPart = $this->extractLocalPart($email);
        $maxLength = 64;
        $consecutiveChars = "";
        for ($i = 0; $i < strlen($localPart); $i++) {
            $char = $localPart[$i];
            if ($consecutiveChars != "" && ($char == $consecutiveChars || $char == "\\" . $consecutiveChars)) {
                $maxLength--;
                if ($maxLength == 0) {
                    return false;
                }
            } else {
                $consecutiveChars = $char;
                $maxLength = 64;
            }
        }
        return true;
    }

    private function validateDomainPresence(string $email): bool
    {
        return str_contains($email, "@");
    }
    private function validateLocalPart(string $email): bool
    {
        $localPart = $this->extractLocalPart($email);
        return preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+$/', $localPart);
    }


    private function validateDomain(string $email): bool
    {
        // Domain validation is complex, consider using a dedicated library
        // This example just checks for a basic structure (letters, numbers, hyphens, dots)
        $domain = $this->extractDomain($email);
        return preg_match('/^[a-zA-Z0-9\-.]+$/', $domain);
    }

    private function extractLocalPart(string $email): string
    {
        $atPos = strpos($email, "@");
        if ($atPos === false) {
            return "";
        }
        return substr($email, 0, $atPos);
    }

    private function extractDomain(string $email): string
    {
        $atPos = strpos($email, "@");
        if ($atPos === false) {
            return "";
        }
        return substr($email, $atPos + 1);
    }
}

