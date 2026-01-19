<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Ambil data user berdasarkan username (Untuk Login)
    public function getByUsername($username)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Ambil semua user (Untuk kelola user)
    public function getAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    // Ambil user by ID (Untuk Edit)
    public function getById($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Tambah User Baru
    public function insert($data)
    {
        $conn = $this->db->connect();
        $sql = "INSERT INTO users (nama_lengkap, username, password, role) VALUES (:nama, :user, :pass, :role)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Update User
    public function update($id, $data)
    {
        $conn = $this->db->connect();
        // Cek apakah password diganti atau tidak
        if (!empty($data['password'])) {
            $sql = "UPDATE users SET nama_lengkap=:nama, username=:user, password=:pass, role=:role WHERE id=:id";
        } else {
            $sql = "UPDATE users SET nama_lengkap=:nama, username=:user, role=:role WHERE id=:id";
            unset($data['password']); // Hapus key password agar tidak error binding
        }
        $data['id'] = $id;
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Hapus User
    public function delete($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Hitung total user (Untuk Dashboard)
    public function countAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT count(*) as total FROM users");
        return $stmt->fetch()['total'];
    }
}
