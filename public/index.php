<?php
date_default_timezone_set('Asia/Jakarta');

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Config & Controllers
require_once '../app/Config/Database.php';
require_once '../app/Controllers/HomeController.php';
require_once '../app/Controllers/BarangController.php'; // Controller Barang
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/UserController.php';

// Ambil parameter URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$act = isset($_GET['act']) ? $_GET['act'] : 'index';

// --- ROUTING ---
switch ($page) {

    // --- HOME & ABOUT ---
    case 'home':
        $controller = new HomeController();
        if ($act == 'about') {
            // Ini untuk membuka halaman 'views/home/about.php' yang tadi dibuat
            $controller->about();
        } else {
            $controller->index();
        }
        break;

    // --- AUTH (LOGIN/LOGOUT) ---
    case 'auth':
        $controller = new AuthController();
        if ($act == 'login') {
            $controller->login(); // Menangani POST login & Tampilan Form
        } elseif ($act == 'logout') {
            $controller->logout();
        } else {
            $controller->index();
        }
        break;

    // --- MANAJEMEN BARANG ---
    case 'barang':
        // --- PROTEKSI (MIDDLEWARE) ---
        // User wajib login untuk mengakses fitur ini
        $protected_actions = ['create', 'store', 'edit', 'update', 'delete', 'export'];

        if (in_array($act, $protected_actions) && !isset($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&act=login');
            exit;
        }
        // -----------------------------

        $controller = new BarangController();

        if ($act == 'create') $controller->create();
        elseif ($act == 'store') $controller->store();
        elseif ($act == 'edit') {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $controller->edit($id);
        } elseif ($act == 'update') $controller->update();
        elseif ($act == 'delete') {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $controller->delete($id);
        } elseif ($act == 'export') {
            $controller->export();
        } else {
            $controller->index();
        }
        break;

    // --- MANAJEMEN USER ---
    case 'user':
        // Proteksi User (Wajib Login)
        // Note: Proteksi 'Admin Only' sudah ada di dalam Constructor UserController
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=auth&act=login');
            exit;
        }

        $controller = new UserController();

        if ($act == 'create') $controller->create();
        elseif ($act == 'store') $controller->store();
        elseif ($act == 'edit') {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $controller->edit($id);
        } elseif ($act == 'update') $controller->update();
        elseif ($act == 'delete') {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $controller->delete($id);
        } else {
            $controller->index();
        }
        break;

    default:
        echo "<h3>404 - Halaman Tidak Ditemukan</h3>";
        echo "<a href='index.php'>Kembali ke Home</a>";
        break;
}
