<?php
namespace App\Middleware;
use App\Controller\UserController;
use App\Response\JsonResponse;

class Autorizacao
{
    private $userController;
    private $ipsPermitidos;
    private $origesPermitidas;
    public function __construct($controller)
    { 
        $this->userController = $controller;
        $this->ipsPermitidos = ['::1', '172.18.0.1','216.172.172.*'];
        $this->origesPermitidas= [
            'http://localhost',
            'http://restfull.faustinopsy.com',
            'https://restfull.faustinopsy.com',
        ];
    }

    public function verificarToken($request, $next)
    {
        
        // $headers = getallheaders();
        
        // $token = $headers['Authorization'] ;
        // if ($this->userController->isValidToken($token)) {
        //     echo JsonResponse::make(['error' => 'Não autorizado'], 401);
        // }
        

        return $next($request);
    }

    public function autorizados($ip,$origin){
 
        // if (!in_array($origin, $this->origesPermitidas)) {
        //     echo JsonResponse::make(['error' => 'Acesso não autorizado origem'], 403);
        //     exit;
        // }
        
        if (!in_array($_SERVER['REMOTE_ADDR'], $this->ipsPermitidos)) {
            echo JsonResponse::make(['error' => 'Acesso não autorizado IP'], 403);
            exit;
        }
    }

}