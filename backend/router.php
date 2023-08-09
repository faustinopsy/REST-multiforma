<?php
require 'UserManager.php';
class Router {
    private $requestMethod;
    private $uri;
    private $routes;

    private $userManager;

    public function __construct($requestMethod, $uri) {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
        $this->userManager = new UserManager();
    }

    public function run() {
        $this->routes();

        $handler = $this->findRouteHandler();

        if ($handler) {
            echo $handler();
        } else {
            echo "404 Not Found";
        }
    }

    private function routes() {
        $this->routes = [
            'GET' => [
                '/backend/usuario/{id}' => function ($id) {
                    header("HTTP/1.1 200 OK");
                    $usuario = $this->userManager->getUserById($id);
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário recuperado com sucesso",
                        'description' => "",
                        'usuario' => $usuario->toArray()
                    ];
                    return json_encode($data);
                },
                '/backend/usuario' => function () {
                    header("HTTP/1.1 200 OK");
                    $usuarios = $this->userManager->getAllUsers();
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuários recuperados com sucesso",
                        'description' => "",
                        'usuarios' => $usuarios
                    ];
                    return json_encode($data);
                }
            ],
            'POST' => [
                '/backend/usuario' => function () {
                    header("HTTP/1.1 201 Created");
                    $body = json_decode(file_get_contents('php://input'), true);
                    $usuario = $this->userManager->createUser($body['nome']);
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário criado com sucesso",
                        'description' => "",
                        'usuario' => $usuario
                    ];
                    return json_encode($data);
                }
            ],
            'PUT' => [
                '/backend/usuario/{id}' => function ($id) {
                    header("HTTP/1.1 200 OK");
                    $body = json_decode(file_get_contents('php://input'), true);
                    $usuario = $this->userManager->updateUser($id, $body['nome']);
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário atualizado com sucesso",
                        'description' => "",
                        'usuario' => $usuario
                    ];
                    return json_encode($data);
                }
            ],
            'DELETE' => [
                '/backend/usuario/{id}' => function ($id) {
                    header("HTTP/1.1 200 OK");
                    $success = $this->userManager->deleteUser($id);
                    if ($success) {
                        $data = [
                            'codigo' => 0,
                            'mensagem' => "Usuário deletado com sucesso",
                            'description' => "Usuário com ID $id foi deletado"
                        ];
                    } else {
                        $data = [
                            'codigo' => 1,
                            'mensagem' => "Erro ao deletar o usuário",
                            'description' => "Ocorreu um problema ao tentar deletar o usuário com ID $id"
                        ];
                    }
                    return json_encode($data);
                }
            ]
        ];
    }
    

    private function findRouteHandler() {
        foreach ($this->routes[$this->requestMethod] as $route => $handler) {
            $routePattern = preg_replace('/\{.*\}/', '([^/]+)', $route);
            if (preg_match("@^$routePattern$@", $this->uri, $matches)) {
                array_shift($matches);
                return function() use ($handler, $matches) {
                    return call_user_func_array($handler, $matches);
                };
            }
        }

        return false;
    }
}
