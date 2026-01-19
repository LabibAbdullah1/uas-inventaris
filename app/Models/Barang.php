<?php
class Barang
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $conn = $this->db->connect();
        // Join ke tabel kategori agar nama kategori muncul
        $sql = "SELECT b.*, k.nama_kategori 
                FROM barang b 
                JOIN kategori k ON b.kategori_id = k.id 
                ORDER BY b.id DESC";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM barang WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert($data)
    {
        $conn = $this->db->connect();
        $sql = "INSERT INTO barang (nama_barang, kategori_id, jumlah, kondisi, keterangan) 
                VALUES (:nama, :kategori, :jumlah, :kondisi, :ket)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $conn = $this->db->connect();
        $sql = "UPDATE barang SET nama_barang=:nama, kategori_id=:kategori, 
                jumlah=:jumlah, kondisi=:kondisi, keterangan=:ket WHERE id=:id";
        $data['id'] = $id;
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM barang WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT count(*) as total FROM barang");
        return $stmt->fetch()['total'];
    }

    // Helper untuk dropdown kategori
    public function getKategori()
    {
        $conn = $this->db->connect();
        return $conn->query("SELECT * FROM kategori")->fetchAll();
    }
}
