<?php
namespace App;

use App\Controller\UserController;
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
                echo $ponte();
            } else {
                header("HTTP/1.1 404 Not Found");
                echo json_encode(['error' => 'Página não encontrada']);
            }
        } catch (\Exception $e) {
            header("HTTP/1.1 500 Erro Interno do Servidor");
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
   
    private function routes() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        $this->routes = [
            'GET' => [
                '/backend/usuario/{id}' => function ($id) {
                    $autorizado=$this->verificarToken();
                    if(!$autorizado){
                        header("HTTP/1.1 401 Não autorizado");
                        $data = [
                            'status' => false,
                            'mensagem' => "Não autorizado",
                            'descricao' => "Token Não validado",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    header("HTTP/1.1 200 OK");
                    $usuario = $this->usercontroller->getUserById($id);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário  não encontrado",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário recuperado com sucesso",
                        'descricao' => "",
                        'usuario' => $usuario
                    ];
                    return json_encode($data);
                },
                '/backend/usuario' => function () {
                    $autorizado=$this->verificarToken();
                    if(!$autorizado){
                        header("HTTP/1.1 401 Não autorizado");
                        $data = [
                            'status' => false,
                            'mensagem' => "Não autorizado",
                            'descricao' => "Token Não validado",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    header("HTTP/1.1 200 OK");
                    $usuarios = $this->usercontroller->getAllUsers();
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuários recuperados com sucesso",
                        'descricao' => "",
                        'usuarios' => $usuarios
                    ];
                    return json_encode($data);
                },
                '/backend/token' => function () {
                    header("HTTP/1.1 200 OK");
                    $token = $this->verificarToken();
                    $data = [
                        'status' => true
                    ];
                    return json_encode($data);
                },
            ],
            'POST' => [
                '/backend/usuario' => function () {
                    $autorizado=$this->verificarToken();
                    if(!$autorizado){
                        header("HTTP/1.1 401 Não autorizado");
                        $data = [
                            'status' => false,
                            'mensagem' => "Não autorizado",
                            'descricao' => "Token Não validado",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    header("HTTP/1.1 201 Created");
                    $body = json_decode(file_get_contents('php://input'), true);
                    $usuario = $this->usercontroller->createUser($body);
                    if(!$usuario){
                        $data = [
                            'status' => false,
                            'mensagem' => "Usuário já existe",
                            'descricao' => "",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário criado com sucesso",
                        'descricao' => "",
                        'usuario' => $usuario
                    ];
                    return json_encode($data);
                }
            ],
            'PUT' => [
                '/backend/usuario/{id}' => function ($id) {
                    $autorizado=$this->verificarToken();
                    if(!$autorizado){
                        header("HTTP/1.1 401 Não autorizado");
                        $data = [
                            'status' => false,
                            'mensagem' => "Não autorizado",
                            'descricao' => "Token Não validado",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    header("HTTP/1.1 200 OK");
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
                        return json_encode($data);
                    }
                    $data = [
                        'status' => true,
                        'mensagem' => "Usuário atualizado com sucesso",
                        'descricao' => "",
                        'usuario' => $id
                    ];
                    return json_encode($data);
                }
            ],
            'DELETE' => [
                '/backend/usuario/{id}' => function ($id) {
                    $autorizado=$this->verificarToken();
                    if(!$autorizado){
                        header("HTTP/1.1 401 Não autorizado");
                        $data = [
                            'status' => false,
                            'mensagem' => "Não autorizado",
                            'descricao' => "Token Não validado",
                            'usuario' => ""
                        ];
                        return json_encode($data);
                    }
                    header("HTTP/1.1 200 OK");
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
                    return json_encode($data);
                }
            ]
        ];
    }
    private function verificarToken() {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;
        if ($token === null || !$this->usercontroller->isValidToken($token)) {
            return false;
        }
        return true;
    }

    private function procuraPonte() {
        foreach ($this->routes[$this->requestMethod] as $route => $ponte) {
            $routePattern = preg_replace('/\{.*\}/', '([^/]+)', $route);
            if (preg_match("@^$routePattern$@", $this->uri, $matches)) {
                array_shift($matches);
                return function() use ($ponte, $matches) {
                    return call_user_func_array($ponte, $matches);
                };
            }
        }

        return false;
    }
}
