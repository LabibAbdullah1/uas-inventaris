<?php

use function PHPSTORM_META\sql_injection_subst;

class User{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // ambil user bedasarkan Username, getAll, getById
    public function getByUsername($username){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll(){
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getById($id){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function insert($data){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("INSERT INTO users (nama_lengkap, username, password, role) VALUES (:nama, :user, :pass, :role)");
        return $stmt->execute([
            ':nama' => $data['nama'],
            ':user' => $data['user'],
            ':pass' => $data['pass'],
            ':role' => $data['role']
        ]);
    }

    public function update( $id, $data){
        $conn = $this->db->connect();

        if (!empty($data['password'])) {
            $stmt = $conn->prepare("UPDATE users SET nama_lengkap = :nama, username = :user, password = :pass, role = :role WHERE id = :id");
            return $stmt->execute([
                ':nama' => $data['nama'],
                ':user' => $data['user'],
                ':pass' => $data['password'],
                ':role' => $data['role'],
                ':id' => $id
            ]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET nama_lengkap = :nama, username = :user, password = :password, role = :role WHERE id = :id");
            return $stmt->execute([
                ':nama' => $data['nama'],
                ':user' => $data['user'],
                ':role' => $data['role'],
                ':id' => $id
            ]);
        }
    }

    public function delete($id){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function countAll(){
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT count(*) as total FROM users");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }
}