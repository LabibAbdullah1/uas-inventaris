<?php
require_once '../app/Models/Audit.php';

class AuditController
{

    // Halaman Utama (List Jadwal)
    public function index()
    {
        $model = new Audit();

        // Admin lihat semua, User lihat yg Aktif saja
        if ($_SESSION['role'] == 'admin') {
            $data['audits'] = $model->getAll();
        } else {
            $data['audits'] = $model->getActive();
        }

        $data['title'] = 'Audit & Stock Opname';
        $this->view('audit/index', $data);
    }

    // [ADMIN] Buat Jadwal Baru
    public function create()
    {
        if ($_SESSION['role'] !== 'admin') header('Location: index.php');

        $data['title'] = 'Buat Jadwal Audit';
        $data['action'] = 'index.php?page=audit&act=store';
        $this->view('audit/form_create', $data);
    }

    // [ADMIN] Simpan Jadwal
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new Audit();
            $data = [
                'judul' => $_POST['judul'],
                'tanggal_mulai' => $_POST['tanggal_mulai'],
                'tanggal_selesai' => $_POST['tanggal_selesai']
            ];

            if ($model->createSchedule($data)) {
                $_SESSION['success'] = "Jadwal Audit berhasil dibuat!";
                header('Location: index.php?page=audit');
            }
        }
    }

    // [USER/ADMIN] Halaman Ceklis / Detail
    public function check($id)
    {
        $model = new Audit();
        $audit = $model->getById($id);
        $details = $model->getDetail($id);

        $data = [
            'title' => 'Pengecekan: ' . $audit['judul'],
            'audit' => $audit,
            'items' => $details
        ];

        // Jika Admin -> Tampilan Laporan (Read Only)
        // Jika User -> Tampilan Form Ceklis (Input)
        if ($_SESSION['role'] == 'admin') {
            $this->view('audit/report', $data);
        } else {
            // Cek apakah jadwal masih aktif?
            if ($audit['status'] == 'Selesai') {
                $_SESSION['error'] = "Audit ini sudah ditutup.";
                header('Location: index.php?page=audit');
                exit;
            }
            $this->view('audit/check_form', $data);
        }
    }

    // [USER] Proses Simpan Ceklis
    public function submit_check()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new Audit();
            $audit_id = $_POST['audit_id'];
            $items = $_POST['items']; // Array dari form

            // Loop semua item yg dikirim form
            foreach ($items as $detail_id => $val) {
                // $val berisi array [status => ..., catatan => ...]
                $status = $val['status'];
                $catatan = $val['catatan'];
                $checker = $_SESSION['nama'];

                $model->updateCheck($detail_id, $status, $catatan, $checker);
            }

            $_SESSION['success'] = "Hasil pengecekan berhasil disimpan!";
            header("Location: index.php?page=audit&act=check&id=$audit_id");
        }
    }

    // [ADMIN] Tutup Audit
    public function close($id)
    {
        if ($_SESSION['role'] !== 'admin') exit;

        $model = new Audit();
        $model->closeAudit($id);
        $_SESSION['success'] = "Audit ditutup. Laporan terkunci.";
        header('Location: index.php?page=audit');
    }

    public function delete($id)
    {
        if ($_SESSION['role'] !== 'admin') exit;

        $model = new Audit();
        $model->delete($id);
        $_SESSION['success'] = "Audit dan data terkait berhasil dihapus.";
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
