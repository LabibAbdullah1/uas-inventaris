<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Sistem Inventaris' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link href="assets/css/style.css" rel="stylesheet">

    <script>
        // Cek tema dari Local Storage segera sebelum Body dirender agar tidak berkedip
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
    </script>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <div class="d-inline-flex align-items-center justify-content-center rounded-3 p-2 shadow-sm"
                    style="width: 36px; height: 36px; background-color: var(--primary); color: #fff;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span style="font-weight: 700; letter-spacing: -0.03em;">Inventaris App</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="d-flex align-items-center ms-auto gap-3">

                    <button onclick="toggleTheme()" class="btn btn-link text-body p-1 text-decoration-none" aria-label="Toggle theme" style="opacity: 0.7;">
                        <svg id="icon-sun" class="d-none" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="icon-moon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                        </svg>
                    </button>

                    <div class="vr opacity-25 d-none d-lg-block"></div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary border-0 bg-transparent dropdown-toggle d-flex align-items-center gap-2 p-0 pe-2"
                                type="button" data-bs-toggle="dropdown">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 32px; height: 32px; background-color: var(--bs-secondary-bg); color: var(--bs-body-color);">
                                    <?= strtoupper(substr($_SESSION['nama'] ?? 'A', 0, 1)); ?>
                                </div>
                                <span class="d-none d-sm-inline-block fw-medium small text-body">
                                    <?= htmlspecialchars($_SESSION['nama'] ?? 'User'); ?>
                                </span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border border-secondary-subtle mt-2" style="border-radius: 12px;">
                                <li class="px-3 py-2 text-center d-sm-none">
                                    <span class="fw-bold small d-block"><?= htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></span>
                                    <span class="badge bg-light text-secondary border mt-1" style="font-size: 0.7em;">
                                        <?= ucfirst($_SESSION['role'] ?? 'Guest'); ?>
                                    </span>
                                </li>
                                <li class="d-sm-none">
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item small py-2 d-flex align-items-center" href="index.php?page=home">
                                        <i class="bi bi-speedometer2 me-2 text-secondary"></i> Dashboard
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item small py-2 d-flex align-items-center" href="index.php?page=barang">
                                        <i class="bi bi-box-seam me-2 text-secondary"></i> Data Barang
                                    </a>
                                </li>

                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item small py-2 d-flex align-items-center" href="index.php?page=user">
                                            <i class="bi bi-people me-2 text-secondary"></i> Kelola User
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item small py-2 text-danger d-flex align-items-center" href="index.php?page=auth&act=logout">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="index.php?page=auth&act=login" class="btn btn-sm btn-primary-custom px-4 shadow-sm">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">