<div class="container d-flex flex-column justify-content-center py-5 mt-4" style="min-height: 75vh;">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="text-center mb-4 fade-up" style="animation-delay: 0.1s;">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3 shadow-sm"
                        style="width: 56px; height: 56px; background-color: var(--primary); color: #fff;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h1 class="h4 fw-bold mb-1">Selamat Datang</h1>
                    <p class="text-secondary small">Silakan login untuk masuk ke Sistem Inventaris.</p>
                </div>

                <div class="card-custom p-4 p-md-5 fade-up" style="animation-delay: 0.2s;">
                    <form action="index.php?page=auth&act=login" method="POST">

                        <div class="mb-3">
                            <label for="username" class="form-label small text-uppercase fw-bold text-secondary">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Masukkan username anda" required autofocus autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label small text-uppercase fw-bold text-secondary">Password</label>
                            </div>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="••••••••" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom shadow-sm fw-bold">
                                Masuk Sistem
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4 fade-up" style="animation-delay: 0.3s;">
                    <a href="index.php" class="text-decoration-none text-secondary small hover-underline">
                        &larr; Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        <?php if (isset($_SESSION['error'])): ?>
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '<?= $_SESSION['error']; ?>',
                confirmButtonColor: '#2563eb',
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#334155'
            });
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
