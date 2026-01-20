<?php
require_once '../app/Models/User.php';

class UserController
{

    public function __construct()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
            exit;
        }
    }

    // ... method index dan create biarkan ...
    public function index()
    {
        $model = new User();
        $data = ['users' => $model->getAll(), 'title' => 'Kelola Pengguna'];
        $this->view('users/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah User', 'action' => 'index.php?page=user&act=store'];
        $this->view('users/form', $data);
    }

    // --- PERBAIKAN STORE (INSERT) ---
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new User();
            // Perhatikan nama key array-nya
            $data = [
                'nama' => $_POST['nama_lengkap'],
                'user' => $_POST['username'],
                'pass' => password_hash($_POST['password'], PASSWORD_DEFAULT), // Key 'pass'
                'role' => $_POST['role']
            ];

            if ($model->insert($data)) {
                $_SESSION['success'] = "User berhasil ditambahkan";
                header('Location: index.php?page=user');
            }
        }
    }

    // ... method edit biarkan ...
    public function edit($id)
    {
        $model = new User();
        $data = [
            'title' => 'Edit User',
            'user' => $model->getById($id),
            'action' => 'index.php?page=user&act=update'
        ];
        $this->view('users/form', $data);
    }

    // --- PERBAIKAN UPDATE ---
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new User();
            $id = $_POST['id'];

            // Siapkan data dasar
            $data = [
                'nama' => $_POST['nama_lengkap'],
                'user' => $_POST['username'],
                'role' => $_POST['role']
            ];

            // Cek Password: Jika diisi, tambahkan ke array
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                $data['password'] = null; // Kirim null agar Model tahu password tidak berubah
            }

            // Panggil model dengan ID dan Data
            if ($model->update($id, $data)) {
                $_SESSION['success'] = "User berhasil diperbarui";
                header('Location: index.php?page=user');
            }
        }
    }

    // ... method delete dan view biarkan ...
    public function delete($id)
    {
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "Tidak bisa menghapus akun sendiri!";
            header('Location: index.php?page=user');
            exit;
        }
        $model = new User();
        if ($model->delete($id)) {
            $_SESSION['success'] = "User berhasil dihapus";
        }
        header('Location: index.php?page=user');
    }

    private function view($viewName, $data = [])
    {
        extract($data);
        require_once '../views/layouts/header.php';
        require_once "../views/$viewName.php";
        require_once '../views/layouts/footer.php';
    }
}
