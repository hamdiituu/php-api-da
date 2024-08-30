<?php
namespace Http\Middlewares;

class AuthMiddleware {
    public function handle() {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }
    }
}