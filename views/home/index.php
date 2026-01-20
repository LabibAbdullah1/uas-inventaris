<div class="hero-section fade-up d-flex align-items-center" style="min-height: 85vh;">
    <div class="container text-center px-4">

        <div class="d-inline-block mb-3">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill shadow-sm border border-primary border-opacity-10" style="letter-spacing: 0.5px;">
                Sistem Informasi Inventaris V2.1
            </span>
        </div>

        <h1 class="display-5 display-md-3 fw-bold mb-4 text-gradient">
            Kelola Aset Kampus
            <br class="d-none d-md-block"> Lebih Simpel & Modern.
        </h1>

        <p class="lead text-muted mb-5 mx-auto" style="max-width: 600px; font-weight: 400;">
            Platform manajemen inventaris yang dirancang untuk kecepatan dan kemudahan.
            Pantau aset, kondisi barang, dan pelaporan dalam satu pintu.
        </p>

        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=home" class="btn btn-primary-custom px-5 py-3 py-sm-2 w-100 w-sm-auto shadow-lg fw-bold">
                    <i class="bi bi-speedometer2 me-2"></i> Buka Dashboard
                </a>
            <?php else: ?>
                <a href="index.php?page=auth&act=login" class="btn btn-primary-custom px-5 py-3 py-sm-2 w-45 w-sm-auto shadow-lg fw-bold">
                    Mulai Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="index.php?page=home&act=about" class="btn btn-outline-secondary px-5 py-3 py-sm-2 w-45 w-sm-auto fw-medium" style="border-radius: 8px;">
                    Pelajari Fitur
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>