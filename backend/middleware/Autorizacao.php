<?php
namespace App\Middleware;
use App\Response\JsonResponse;

class Autorizacao
{
    private $userController;

    public function __construct($userController)
    {
        $this->userController = $userController;
    }

    public function verificarToken($request, $next)
    {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;
        if ($token === null || !$this->userController->isValidToken($token)) {
            return JsonResponse::make(['error' => 'Não autorizado'], 401);
        }
        

        return $next($request);
    }
}