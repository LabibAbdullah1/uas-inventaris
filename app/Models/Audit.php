<?php
class Audit
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Ambil Semua Jadwal (Join ke User & Kategori biar namanya muncul)
    public function getAll()
    {
        $conn = $this->db->connect();
        $sql = "SELECT a.*, u.nama_lengkap as petugas, k.nama_kategori 
                FROM audit_jadwal a
                LEFT JOIN users u ON a.assigned_to = u.id
                LEFT JOIN kategori k ON a.target_kategori_id = k.id
                ORDER BY a.id DESC";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll();
    }

    // Ambil Jadwal Khusus User yang Login
    public function getAssignedToUser($user_id)
    {
        $conn = $this->db->connect();
        $sql = "SELECT a.*, u.nama_lengkap as petugas, k.nama_kategori 
                FROM audit_jadwal a
                LEFT JOIN users u ON a.assigned_to = u.id
                LEFT JOIN kategori k ON a.target_kategori_id = k.id
                WHERE a.status = 'Aktif' AND a.assigned_to = :uid
                ORDER BY a.id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':uid', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ... method getById dan getDetail SAMA SEPERTI SEBELUMNYA ...
    public function getDetail($audit_id)
    {
        $conn = $this->db->connect();
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

    // --- UPDATED CREATE SCHEDULE ---
    public function createSchedule($data)
    {
        $conn = $this->db->connect();
        try {
            $conn->beginTransaction();

            // 1. Insert Header Jadwal dengan Assignment & Kategori
            $sql = "INSERT INTO audit_jadwal (judul, tanggal_mulai, tanggal_selesai, status, assigned_to, target_kategori_id) 
                    VALUES (:judul, :tm, :ts, 'Aktif', :uid, :kid)";
            $stmt = $conn->prepare($sql);

            // Handle jika kategori dipilih "Semua" (NULL)
            $kategori_id = empty($data['kategori_id']) ? null : $data['kategori_id'];

            $stmt->execute([
                ':judul' => $data['judul'],
                ':tm' => $data['tanggal_mulai'],
                ':ts' => $data['tanggal_selesai'],
                ':uid' => $data['assigned_to'],
                ':kid' => $kategori_id
            ]);

            $audit_id = $conn->lastInsertId();

            // 2. Snapshot: Copy barang sesuai Kategori
            if ($kategori_id) {
                // Jika pilih kategori tertentu
                $sql_snapshot = "INSERT INTO audit_detail (audit_id, barang_id, kondisi_awal)
                                 SELECT :aid, id, kondisi FROM barang WHERE kategori_id = :kid";
                $stmt_snap = $conn->prepare($sql_snapshot);
                $stmt_snap->bindParam(':aid', $audit_id);
                $stmt_snap->bindParam(':kid', $kategori_id);
            } else {
                // Jika pilih "Semua Kategori"
                $sql_snapshot = "INSERT INTO audit_detail (audit_id, barang_id, kondisi_awal)
                                 SELECT :aid, id, kondisi FROM barang";
                $stmt_snap = $conn->prepare($sql_snapshot);
                $stmt_snap->bindParam(':aid', $audit_id);
            }

            $stmt_snap->execute();

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    // ... method updateCheck, closeAudit, delete SAMA SEPERTI SEBELUMNYA ...
    public function updateCheck($id_detail, $status, $catatan, $checker)
    {
        $conn = $this->db->connect();
        $sql = "UPDATE audit_detail SET status_fisik = :stat, catatan = :cat, checked_at = NOW(), checker_name = :chk WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':stat' => $status, ':cat' => $catatan, ':chk' => $checker, ':id' => $id_detail]);
    }

    public function closeAudit($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("UPDATE audit_jadwal SET status = 'Selesai' WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM audit_jadwal WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
