// UserManager.php
<?php
require_once 'Model.php';
require_once 'User.php';
require_once 'AdminUser.php';

class UserManager extends Model {

    public function getUserById($id) {
        $data = $this->find($id);
        return new User($data['id'], $data['nome']);
    }

    public function getAllUsers() {
        $allData = $this->findAll();
        $users = [];
        foreach($allData as $data) {
            $users[] = new User($data['id'], $data['nome']);
        }
        return $users;
    }

    public function createUser($nome) {
        $data = ['nome' => $nome];
        $createdData = $this->create($data);
        return new User($createdData['id'], $createdData['nome']);
    }

    public function updateUser($id, $nome) {
        $data = ['nome' => $nome];
        $updatedData = $this->update($id, $data);
        return new User($updatedData['id'], $updatedData['nome']);
    }

    public function deleteUser($id) {
        return $this->delete($id);
    }

    public function createAdmin($nome, $privileges) {
        $data = ['nome' => $nome, 'privileges' => $privileges];
        $createdData = $this->create($data);
        return new AdminUser($createdData['id'], $createdData['nome'], $createdData['privileges']);
    }
}
