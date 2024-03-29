<?php

namespace KPZadatak\Services;

use KPZadatak\Core\DB\Contracts\DatabaseInterface;
use KPZadatak\Core\Services\Contracts\MailerInterface;
use KPZadatak\Core\Services\EmailValidator;
use KPZadatak\Exceptions\DatabaseException;
use KPZadatak\Exceptions\FraudException;
use KPZadatak\Exceptions\MailerException;
use KPZadatak\Exceptions\ValidationException;
use KPZadatak\Services\Contracts\EmailFraudDetectorInterface;

class RegisterUser
{
    private DatabaseInterface $db;
    private MailerInterface $mailer;
    private EmailValidator $emailValidator;
    private EmailFraudDetectorInterface $detector;

    /**
     * @param DatabaseInterface $db
     * @param MailerInterface $mailer
     * @param EmailValidator $emailValidator
     * @param EmailFraudDetectorInterface $detector
     */
    public function __construct(DatabaseInterface $db, MailerInterface $mailer, EmailValidator $emailValidator, EmailFraudDetectorInterface $detector
    )
    {
        $this->db = $db;
        $this->mailer = $mailer;
        $this->emailValidator = $emailValidator;
        $this->detector = $detector;
    }

    /**
     * @param array $request
     *
     * @return void
     * @throws DatabaseException
     * @throws FraudException
     * @throws MailerException
     * @throws ValidationException
     */
    public function store(array $request): void
    {
        $email = $request['email'] ?? '';
        $password = $request['password'] ?? '';
        $password2 = $request['password2'] ?? '';

        if (empty($email) || empty($password) || mb_strlen($password) < 8 || $password != $password2 || !$this->emailValidator->validateEmail($email)) {
            throw new ValidationException('Invalid email or password.');
        }

        $user = $this->db->readOne('users', 'email = ?', [$email]);
        if ($user) {
            throw new ValidationException('Email already exists.');
        }

        if($this->detector->isFraudulent($email)) {
            throw new FraudException('Email does not comply.');
        }

        $userId = $this->db->create('users', ['email' => $email, 'password' => $password]);
        if (!$userId) {
            throw new DatabaseException('Failed to create user.');
        }

        $this->db->create('user_log', ['action' => 'register', 'user_id' => $userId]);

        if (!$this->mailer->send('admin@kupujemprodajem.com', 'New user has registered', 'Hello', '')) {
            throw new MailerException('Failed to send an email.');
        }
    }

}
