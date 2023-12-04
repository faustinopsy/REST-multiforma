<?php
namespace App;
require_once __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;
use App\Model\Model;
use App\User\User;
use App\Controller\UserController;
$algoritimo='HS256';
$model = new Model();
$user = new User();
$usercontroller;


$usercontroller = new UserController();
$ip=isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

//$autorizado = new Autorizacao();
//$autorizado->autorizados($ip,$origin);
$secretKey = $usercontroller->generateToken();
$data = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-cache, no-store, must-revalidate');
if (isset($data['username']) && isset($data['password'])) {

  



    $username = $data['username'];
    $password = $data['password'];
    
    $user->setNome($username);
    $user->setSenha($password);

    $data = $model->read('users', ['nome' => $username]);
    if (!$data) {
        echo json_encode(['error' => 'Erro interno do servidor.'], 500);
    }
    if (!empty($data) && password_verify($password, $data[0]['senha'])) {
        $user->setId($data[0]['id']);

        $payload = [
            "iss" => "local.com",
            "aud" => "local.com",
            "iat" => time(),
            "exp" => time() + (60 * 60),  
            "data" => [
                "userId" => $user->getId(),
                "username" => $user->getNome(),
            ]
        ];
        

        $jwt = JWT::encode($payload, $secretKey, $algoritimo);
        $model->create('token', ['id_user' => $user->getId(),'token'=> $jwt]);
        echo json_encode(['token' => $jwt]);
    } else {
        echo json_encode(['error' => 'Nome de usuário ou senha inválidos.'], 401);
    }
} else {
    echo json_encode(['error' => 'requisição inválida.'], 400);
}

