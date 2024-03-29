<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$db = new \KPZadatak\Core\DB\MySqlDB();
$mailer = new \KPZadatak\Core\Services\DefaultMailer();
$validator = new \KPZadatak\Core\Services\EmailValidator();
$fraudDetector = new \KPZadatak\Services\Mocks\MaxMind(true);
$userService = new \KPZadatak\Services\RegisterUser($db, $mailer, $validator, $fraudDetector);

$controller = new \KPZadatak\Controllers\RegistrationController($userService);

$controller->store([
    'email'     => 'testemail@gmail.com',
    'password'  => 'password',
    'password2' => 'password'
]);
