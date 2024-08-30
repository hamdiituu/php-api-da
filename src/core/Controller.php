<?php

namespace Core;

class Controller
{
    /**
     * Send a JSON response with the given data and status code.
     *
     * @param mixed $data Data to send as JSON.
     * @param int $statusCode HTTP status code (default: 200).
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    /**
     * Send a successful response with the given data.
     *
     * @param mixed $data Data to send as JSON.
     */
    protected function ok($data = null)
    {
        $this->jsonResponse($data, 200);
    }

    /**
     * Send a created response with the given data.
     *
     * @param mixed $data Data to send as JSON (optional).
     */
    protected function created($data = null)
    {
        $this->jsonResponse($data, 201);
    }

    /**
     * Send a no content response.
     */
    protected function noContent()
    {
        $this->jsonResponse(null, 204);
    }

    /**
     * Send a bad request response with the given message.
     *
     * @param string $message Error message.
     */
    protected function badRequest($message = 'Bad Request')
    {
        $this->jsonResponse(['error' => $message], 400);
    }

    /**
     * Send an unauthorized response with the given message.
     *
     * @param string $message Error message (default: 'Unauthorized').
     */
    protected function unauthorized($message = 'Unauthorized')
    {
        $this->jsonResponse(['error' => $message], 401);
    }

    /**
     * Send a forbidden response with the given message.
     *
     * @param string $message Error message (default: 'Forbidden').
     */
    protected function forbidden($message = 'Forbidden')
    {
        $this->jsonResponse(['error' => $message], 403);
    }

    /**
     * Send a not found response with a default message.
     *
     * @param string $message Error message (default: 'Resource not found').
     */
    protected function notFound($message = 'Resource not found')
    {
        $this->jsonResponse(['error' => $message], 404);
    }

    /**
     * Send an internal server error response with the given message.
     *
     * @param string $message Error message (default: 'Internal Server Error').
     */
    protected function internalServerError($message = 'Internal Server Error')
    {
        $this->jsonResponse(['error' => $message], 500);
    }

    /**
     * Get a specific header value.
     *
     * @param string $name Name of the header.
     * @return string|null Value of the header or null if not set.
     */
    protected function getHeader($name)
    {
        $headers = getallheaders();
        return isset($headers[$name]) ? $headers[$name] : null;
    }

    /**
     * Get POST data from the form body.
     *
     * @return array Associative array of POST data.
     */
    protected function getFormData()
    {
        return $_POST;
    }

    /**
     * Get JSON data from the request body.
     *
     * @return array Associative array of JSON data.
     */
    protected function getJsonData()
    {
        $data = file_get_contents('php://input');
        return json_decode($data, true) ?? [];
    }
}