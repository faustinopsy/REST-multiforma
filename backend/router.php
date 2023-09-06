<?php
namespace App;

use App\Controller\UserController;
use App\Middleware\Autorizacao;
use App\Response\JsonResponse;
class Router {
    private $requestMethod;
    private $uri;
    private $routes;
    private $usercontroller;

    public function __construct($requestMethod, $uri) {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
        $this->usercontroller = new UserController();
        $this->routes();
    }
    public function run() {
        try {
            $ponte = $this->procuraPonte();
    
            if ($ponte) {
                $request = [
                    'method' => $this->requestMethod,
                    'uri' => $this->uri,
                ];
                $autorizacaoMiddleware = new Autorizacao($this->usercontroller);
                $response = $autorizacaoMiddleware->verificarToken($request, function($request) use ($ponte) {
                    echo $ponte();
                });
                echo $response;
            } else {
                echo JsonResponse::make(['error' => 'Página não encontrada'], 404);
            }
        } catch (\Exception $e) {
            $this->errosInternos($e);
        }
    }
    
    private function errosInternos(\Exception $e) {
  
        error_log($e->getMessage());
    
        if ($e instanceof NotFoundException) {
            echo JsonResponse::make(['error' => 'Recurso não encontrado'], 404);
        } elseif ($e instanceof ValidationException) {
            echo JsonResponse::make(['error' => 'Dados inválidos', 'errors' => $e->getErrors()], 422);
        } else {
            echo JsonResponse::make(['error' => 'Erro interno do servidor'], 500);
        }
    }
    
    private function routes() {
        $ips_permitidos = ['::1', '123.123.123.124'];
        if (!in_array($_SERVER['REMOTE_ADDR'], $ips_permitidos)) {
            echo JsonResponse::make(['error' => 'Acesso não autorizado'], 403);
            exit;
        }
        // $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        // $origens_permitidas = [
        //     'http://localhost',
        //     'https://localhost',
        // ];
        
        // if (!in_array($origin, $origens_permitidas)) {
        //     echo JsonResponse::make(['error' => 'Acesso não autorizado'], 403);
        //     return;
        // }
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        $this->routes = [
            'GET' => [
                '/backend/usuario/{id}' => function ($id) {
                    $usuario = $this->usercontroller->getUserById($id);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário  não encontrado",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        return JsonResponse::make($data, 200);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário recuperado com sucesso",
                        'descricao' => "",
                        'usuario' => $usuario
                    ];
                    return JsonResponse::make($data, 200);
                },
                '/backend/usuario' => function () {
                    $usuarios = $this->usercontroller->getAllUsers();
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuários recuperados com sucesso",
                        'descricao' => "",
                        'usuarios' => $usuarios
                    ];
                    return JsonResponse::make($data, 200);
                }
            ],
            'POST' => [
                '/backend/usuario' => function () {
                    $body = json_decode(file_get_contents('php://input'), true);
                    $usuario = $this->usercontroller->createUser($body);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário já existe",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        return JsonResponse::make($data, 200);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário criado com sucesso",
                        'descricao' => "",
                        'usuario' => $usuario
                    ];
                    return JsonResponse::make($data, 201);
                }
            ],
            'PUT' => [
                '/backend/usuario/{id}' => function ($id) {
                    header('Content-Type: application/json');
                    $body = json_decode(file_get_contents('php://input'), true);
                    $usuario = $this->usercontroller->updateUser($id, $body);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário não encontrado",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        return JsonResponse::make($data, 200);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário atualizado com sucesso",
                        'descricao' => "",
                        'usuario' => $id
                    ];
                    return JsonResponse::make($data, 200);
                }
            ],
            'DELETE' => [
                '/backend/usuario/{id}' => function ($id) {
                    $success = $this->usercontroller->deleteUser($id);
                    if ($success) {
                        $data = [
                            'status' => true,
                            'mensagem' => "Usuário deletado com sucesso",
                            'descricao' => "Usuário com ID $id foi deletado"
                        ];
                    } else {
                        $data = [
                            'status' => false,
                            'mensagem' => "Erro ao deletar o usuário",
                            'descricao' => "Ocorreu um problema ao tentar deletar o usuário com ID $id"
                        ];
                    }
                    return JsonResponse::make($data, 200);
                }
            ]
        ];
    }


    private function correspondeRota($rota, $uri) {
        $rotaPadrao = preg_replace('/\{.*\}/', '([^/]+)', $rota);
        return preg_match("@^$rotaPadrao$@", $uri, $matches) ? $matches : false;
    }
    
    private function procuraPonte() {
        foreach ($this->routes[$this->requestMethod] as $rota => $ponte) {
            $matches = $this->correspondeRota($rota, $this->uri);
            if ($matches) {
                array_shift($matches);
                return function() use ($ponte, $matches) {
                    return call_user_func_array($ponte, $matches);
                };
            }
        }
    
        return false;
    }
    
}
