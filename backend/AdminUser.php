<?php
require_once 'Users.php';
class AdminUser extends User {
    private $privileges;

    public function __construct($id, $nome, $privileges = []) {
        parent::__construct($id, $nome);
        $this->setPrivileges($privileges);
    }

    public function getPrivileges() {
        return $this->privileges;
    }

    public function setPrivileges($privileges) {
        $this->privileges = $privileges;
    }

    public function getType() {
        return 'Admin';
    }

    public function toArray() {
        $data = parent::toArray();
        $data['privileges'] = $this->getPrivileges();
        return $data;
    }
}