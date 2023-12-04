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
    private $autorizado;

    public function __construct($requestMethod, $uri) {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
        $this->usercontroller = new UserController();
        //$this->autorizado = new Autorizacao($this->usercontroller);
        $this->routes();
    }
    public function run() {
        $this->usercontroller->limparToken();
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
        $ip=isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        //$this->autorizado->autorizados($ip,$origin);

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        $this->routes = [
            'GET' => [
                '/usuario/{id}' => function ($id) {
                    $usuario = $this->usercontroller->getUserById($id);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário  não encontrado",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        echo json_encode($data, 200);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário recuperado com sucesso",
                        'descricao' => "",
                        'usuario' => $usuario
                    ];
                    echo json_encode($data, 200);
                },
                '/usuario' => function () {
                    $usuarios = $this->usercontroller->getAllUsers();
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuários recuperados com sucesso",
                        'descricao' => "",
                        'usuarios' => $usuarios
                    ];
                    echo json_encode($data, 200);
                }
            ],
            'POST' => [
                '/usuario' => function () {
                    $body = json_decode(file_get_contents('php://input'), true);
                    $usuario = $this->usercontroller->createUser($body);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário já existe",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        echo json_encode($data, 200);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário criado com sucesso",
                        'descricao' => "",
                        'usuario' => $usuario
                    ];
                    echo json_encode($data, 201);
                }
            ],
            'PUT' => [
                '/usuario/{id}' => function ($id) {
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
                        echo json_encode($data, 200);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário atualizado com sucesso",
                        'descricao' => "",
                        'usuario' => $id
                    ];
                    echo json_encode($data, 200);
                }
            ],
            'DELETE' => [
                '/usuario/{id}' => function ($id) {
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
                    echo json_encode($data, 200);
                }
            ],
            'OPTIONS' => [
                '/usuario' => function() {
                    header('HTTP/1.1 200 OK');
                    return;
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
