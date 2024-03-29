<?php

namespace KPZadatak\Controllers;

use KPZadatak\Core\Services\ResponseService;
use KPZadatak\Exceptions\DatabaseException;
use KPZadatak\Exceptions\FraudException;
use KPZadatak\Exceptions\MailerException;
use KPZadatak\Exceptions\ValidationException;
use KPZadatak\Services\RegisterUser;

class RegistrationController
{
    private RegisterUser $registerUser;

    /**
     * @param RegisterUser $registerUser
     */
    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    /**
     * @param array $request
     *
     * @return void
     */
    public function store(array $request): void
    {
        try {
            $this->registerUser->store($request);
            ResponseService::sendSuccess('User created successfully.');
        } catch (ValidationException|DatabaseException|FraudException|MailerException $e) {
            ResponseService::sendError($e->getMessage());
        } catch (\Exception $e) {
            ResponseService::sendError('An error occurred while processing your request. ' . $e->getMessage());
        }
    }
}
