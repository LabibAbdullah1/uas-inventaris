<?php
require_once '../app/Models/User.php';

class AuthController
{

    // Tampilkan Halaman Login
    public function index()
    {
        // Jika sudah login, lempar ke home
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=home');
            exit;
        }
        // Tampilkan View
        require_once '../views/layouts/header.php';
        require_once '../views/auth/login.php';
        require_once '../views/layouts/footer.php';
    }

    // Proses Login
    public function login()
    {
        // Jika POST (User klik tombol login)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->getByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Set Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];

                header('Location: index.php?page=home');
                exit;
            } else {
                $_SESSION['error'] = "Username atau Password salah!";
                header('Location: index.php?page=auth&act=login');
                exit;
            }
        }
        // --- PERBAIKAN DI SINI ---
        // Jika GET (User baru buka link), tampilkan form login
        else {
            $this->index();
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?page=auth');
        exit;
    }

    // Helper untuk menangani kasus user iseng akses method authenticate
    public function authenticate()
    {
        $this->login();
    }
}
