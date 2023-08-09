<?php

class Router {
    private $requestMethod;
    private $uri;
    private $routes;

    public function __construct($requestMethod, $uri) {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
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
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário recuperado com sucesso",
                        'description' => "",
                        'usuario' => ['id' => $id, 'nome' => 'Carlos']
                    ];
                    return json_encode($data);
                },
                '/backend/usuario' => function () {
                    header("HTTP/1.1 200 OK");
                    
                    // Simulação de banco de dados
                    $allUsuarios = [
                        ['id' => 1, 'nome' => 'Carlos'],
                        ['id' => 2, 'nome' => 'Ana'],
                        ['id' => 3, 'nome' => 'Roberto'],
                        ['id' => 4, 'nome' => 'Maria'],
                        // ... (mais usuários até 10 ou mais)
                    ];

                    // Simulando pegar os primeiros 10 usuários
                    $usuarios = array_slice($allUsuarios, 0, 10);

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
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário criado com sucesso",
                        'description' => "",
                        'usuario' => ['id' => 2, 'nome' => $body['nome']]
                    ];
                    return json_encode($data);
                }
            ],
            'PUT' => [
                '/backend/usuario/{id}' => function ($id) {
                    header("HTTP/1.1 200 OK");
                    $body = json_decode(file_get_contents('php://input'), true);
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário atualizado com sucesso",
                        'description' => "",
                        'usuario' => ['id' => $id, 'nome' => $body['nome']]
                    ];
                    return json_encode($data);
                }
            ],
            'DELETE' => [
                '/backend/usuario/{id}' => function ($id) {
                    header("HTTP/1.1 200 OK");
                    $data = [
                        'codigo' => 0,
                        'mensagem' => "Usuário deletado com sucesso",
                        'description' => "Usuário com ID $id foi deletado",
                    ];
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
