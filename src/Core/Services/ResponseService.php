<?php

namespace KPZadatak\Core\Services;

class ResponseService
{
    /**
     * Sends a JSON response.
     *
     * @param mixed $data The data to send in the response.
     * @param int $status The HTTP status code (default is 200).
     *
     * @return void
     */
    public static function sendJson($data, int $status = 200): void
    {
        header('Content-Type: application/json');

        http_response_code($status);

        echo json_encode($data);
        exit;
    }

    /**
     * Convenience method for sending an error response.
     *
     * @param string $message The error message.
     * @param int $status The HTTP status code (default is 400).
     *
     * @return void
     */
    public static function sendError(string $message, int $status = 400): void
    {
        self::sendJson(['success' => false, 'error' => $message], $status);
    }

    /**
     * Convenience method for sending a success response.
     *
     * @param mixed $data The data to include in the response.
     * @param int $status The HTTP status code (default is 200).
     *
     * @return void
     */
    public static function sendSuccess($data, int $status = 200): void
    {
        self::sendJson(['success' => true, 'data' => $data], $status);
    }
}
