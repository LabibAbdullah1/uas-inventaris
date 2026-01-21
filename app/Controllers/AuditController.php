<?php
require_once '../app/Models/Audit.php';
require_once '../app/Models/User.php';   // Load Model User
require_once '../app/Models/Barang.php'; // Load Model Barang (untuk getKategori)

class AuditController
{
    public function index()
    {
        $model = new Audit();

        // Admin lihat semua, User CUMA lihat yang DITUGASKAN ke dia
        if ($_SESSION['role'] == 'admin') {
            $data['audits'] = $model->getAll();
        } else {
            $data['audits'] = $model->getAssignedToUser($_SESSION['user_id']);
        }

        $data['title'] = 'Audit & Stock Opname';
        $this->view('audit/index', $data);
    }

    public function create()
    {
        if ($_SESSION['role'] !== 'admin') header('Location: index.php');

        // Ambil Data Pendukung untuk Dropdown
        $userModel = new User();
        $barangModel = new Barang();

        $data['title'] = 'Buat Jadwal Audit';
        $data['users'] = $userModel->getAll(); // Untuk dropdown "Tugaskan Ke"
        $data['kategori'] = $barangModel->getKategori(); // Untuk dropdown "Filter Kategori"
        $data['action'] = 'index.php?page=audit&act=store';

        $this->view('audit/form_create', $data);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new Audit();
            $data = [
                'judul' => $_POST['judul'],
                'tanggal_mulai' => $_POST['tanggal_mulai'],
                'tanggal_selesai' => $_POST['tanggal_selesai'],
                'assigned_to' => $_POST['assigned_to'],     // Tangkap ID Petugas
                'kategori_id' => $_POST['kategori_id']      // Tangkap ID Kategori
            ];

            if ($model->createSchedule($data)) {
                $_SESSION['success'] = "Jadwal Audit berhasil dibuat & ditugaskan!";
                header('Location: index.php?page=audit');
            }
        }
    }

    public function check($id)
    {
        $model = new Audit();
        $audit = $model->getById($id);

        // PROTEKSI: Jika User biasa mencoba akses audit orang lain
        if ($_SESSION['role'] !== 'admin') {
            if ($audit['assigned_to'] != $_SESSION['user_id']) {
                $_SESSION['error'] = "Anda tidak memiliki akses ke tugas audit ini.";
                header('Location: index.php?page=audit');
                exit;
            }
        }

        $details = $model->getDetail($id);

        $data = [
            'title' => 'Pengecekan: ' . $audit['judul'],
            'audit' => $audit,
            'items' => $details
        ];

        if ($_SESSION['role'] == 'admin') {
            $this->view('audit/report', $data);
        } else {
            if ($audit['status'] == 'Selesai') {
                $_SESSION['error'] = "Audit ini sudah ditutup.";
                header('Location: index.php?page=audit');
                exit;
            }
            $this->view('audit/check_form', $data);
        }
    }

    // ... method submit_check, close, delete, view SAMA SEPERTI SEBELUMNYA ...
    public function submit_check()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new Audit();
            $audit_id = $_POST['audit_id'];
            $items = $_POST['items'];

            foreach ($items as $detail_id => $val) {
                $status = $val['status'];
                $catatan = $val['catatan'];
                $checker = $_SESSION['nama'];
                $model->updateCheck($detail_id, $status, $catatan, $checker);
            }
            $_SESSION['success'] = "Hasil pengecekan berhasil disimpan!";
            header("Location: index.php?page=audit&act=check&id=$audit_id");
        }
    }

    public function close($id)
    {
        if ($_SESSION['role'] !== 'admin') exit;
        $model = new Audit();
        $model->closeAudit($id);
        $_SESSION['success'] = "Audit ditutup.";
        header('Location: index.php?page=audit');
    }

    public function delete($id)
    {
        if ($_SESSION['role'] !== 'admin') exit;
        $model = new Audit();
        $model->delete($id);
        $_SESSION['success'] = "Audit dihapus.";
        header('Location: index.php?page=audit');
    }

    private function view($viewName, $data = [])
    {
        extract($data);
        require_once '../views/layouts/header.php';
        require_once "../views/$viewName.php";
        require_once '../views/layouts/footer.php';
    }
}
