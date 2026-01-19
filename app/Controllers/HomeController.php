<?php
require_once '../app/Models/Barang.php';
require_once '../app/Models/User.php';

class HomeController
{
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $barangModel = new Barang();
            $userModel = new User();

            // Ambil semua barang
            $allBarang = $barangModel->getAll();

            // Ambil 5 barang terbaru (slice array)
            $barangTerbaru = array_slice($allBarang, 0, 5);

            $data = [
                'total_barang' => $barangModel->countAll(),
                'total_user' => $userModel->countAll(),
                'barang_terbaru' => $barangTerbaru, // <-- Tambahan ini penting!
                'title' => 'Dashboard Inventaris'
            ];

            $this->view('home/dashboard', $data);
        } else {
            $this->view('home/index', ['title' => 'Selamat Datang']);
        }
    }

    public function about()
    {
        $this->view('home/about', ['title' => 'Tentang Aplikasi']);
    }

    // Helper View Wrapper
    private function view($viewName, $data = [])
    {
        extract($data);
        // Landing page (home/index) mungkin punya layout beda, tapi kita samakan header/footer biar rapi
        require_once '../views/layouts/header.php';
        require_once "../views/$viewName.php";
        require_once '../views/layouts/footer.php';
    }
}
