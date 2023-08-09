<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

// GET: Recuperar informações do usuário
$app->get('/backend/usuario/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    // Aqui, você recuperaria o usuário do banco de dados usando o $id
    // Para fins de demonstração, vamos retornar um usuário mock
    $data = ['id' => $id, 'nome' => 'Carlos'];
    return $response->withJson($data, 200);
});

// POST: Criar um novo usuário
$app->post('/backend/usuario', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    // Aqui, você salvaria o usuário no banco de dados
    // Para fins de demonstração, vamos assumir que o usuário foi criado com o ID 2
    $data = ['id' => 2, 'nome' => $body['nome']];
    return $response->withJson($data, 201);
});

// PUT: Atualizar usuário
$app->put('/backend/usuario/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $body = $request->getParsedBody();
    // Aqui, você atualizaria o usuário no banco de dados usando o $id
    // Para fins de demonstração, vamos retornar o usuário atualizado
    $data = ['id' => $id, 'nome' => $body['nome']];
    return $response->withJson($data, 200);
});

// DELETE: Deletar usuário
$app->delete('/backend/usuario/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    // Aqui, você deletaria o usuário do banco de dados usando o $id
    // Para fins de demonstração, vamos retornar uma mensagem de sucesso
    $data = ['message' => "Usuário com ID $id foi deletado"];
    return $response->withJson($data, 200);
});

$app->run();
