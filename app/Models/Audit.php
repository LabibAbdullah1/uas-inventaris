<?php
class Audit
{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // Ambil Semua Jadwal
    public function getAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT * FROM audit_jadwal ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    // Ambil Jadwal Aktif Saja (Untuk User)
    public function getActive()
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT * FROM audit_jadwal WHERE status = 'Aktif' ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    // Ambil Detail Pengecekan per Jadwal
    public function getDetail($audit_id)
    {
        $conn = $this->db->connect();
        // Join ke tabel Barang untuk ambil nama & kategori
        $sql = "SELECT d.*, b.nama_barang, b.jumlah, k.nama_kategori 
                FROM audit_detail d
                JOIN barang b ON d.barang_id = b.id
                LEFT JOIN kategori k ON b.kategori_id = k.id
                WHERE d.audit_id = :aid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':aid', $audit_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM audit_jadwal WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // FITUR SPESIAL: Buat Jadwal + Snapshot Data Barang
    public function createSchedule($data)
    {
        $conn = $this->db->connect();
        try {
            $conn->beginTransaction();

            // 1. Insert Header Jadwal
            $sql = "INSERT INTO audit_jadwal (judul, tanggal_mulai, tanggal_selesai, status) 
                    VALUES (:judul, :tm, :ts, 'Aktif')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':judul' => $data['judul'],
                ':tm' => $data['tanggal_mulai'],
                ':ts' => $data['tanggal_selesai']
            ]);

            $audit_id = $conn->lastInsertId();

            // 2. Snapshot: Copy semua barang saat ini ke tabel detail
            // Ini query canggih: Insert select (memindahkan data antar tabel)
            $sql_snapshot = "INSERT INTO audit_detail (audit_id, barang_id, kondisi_awal)
                             SELECT :aid, id, kondisi FROM barang";
            $stmt_snap = $conn->prepare($sql_snapshot);
            $stmt_snap->bindParam(':aid', $audit_id);
            $stmt_snap->execute();

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    // Update Hasil Ceklis (User)
    public function updateCheck($id_detail, $status, $catatan, $checker)
    {
        $conn = $this->db->connect();
        $sql = "UPDATE audit_detail SET 
                status_fisik = :stat, 
                catatan = :cat, 
                checked_at = NOW(), 
                checker_name = :chk 
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':stat' => $status,
            ':cat' => $catatan,
            ':chk' => $checker,
            ':id' => $id_detail
        ]);
    }

    public function delete($id_detail)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM audit_jadwal WHERE id = :id");
        $stmt->bindParam(':id', $id_detail);
        return $stmt->execute();
    }

    // Tutup Jadwal (Admin)
    public function closeAudit($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("UPDATE audit_jadwal SET status = 'Selesai' WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
