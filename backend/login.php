<?php
// login.php
require '../vendor/autoload.php';  // Carrega a biblioteca do JWT

use \Firebase\JWT\JWT;
use App\Model\Model;
use App\User\User;
use App\Controller\UserController;
use App\Router;
$algoritimo='HS256';
$model = new Model();
$user = new User();

$usercontroller = new UserController();

if ($usercontroller->verificarToken()) {
    http_response_code(400);
    echo json_encode(array('error' => 'Você já está autenticado.'));
    exit;
}
$secretKey = $usercontroller->generateToken();
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['username']) && isset($data['password'])){
    $username = $data['username'];
    $password = $data['password'];
    
    $user->setNome($username);
    $user->setSenha($password);

    $data = $model->read('users', ['nome' => $username]);
    if (!empty($data) && password_verify($password, $data[0]['senha'])) {
        $user->setId($data[0]['id']);

        $payload = array(
            "iss" => "local.com",
            "aud" => "local.com",
            "iat" => time(),
            "exp" => time() + (60 * 60),  
            "data" => array(
                "userId" => $user->getId(),
                "username" => $user->getNome(),
            )
        );
        

        $jwt = JWT::encode($payload, $secretKey, $algoritimo);
        $model->create('token', ['id_user' => $user->getId(),'token'=> $jwt]);
        echo json_encode(array('token' => $jwt));
        } 
        else{
       
        http_response_code(401);
        echo json_encode(array('error' => 'Nome de usuário ou senha inválidos.'));
    }
}
else{
   
    http_response_code(400);
    echo json_encode(array('error' => 'Requisição inválida.'));
}
?>
