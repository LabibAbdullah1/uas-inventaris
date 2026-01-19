</div>
</main>

<footer class="py-4 mt-auto border-top" style="border-color: var(--border) !important; background-color: var(--bg-card);">
    <div class="container text-center">
        <p class="m-0 small text-secondary">
            &copy; <?= date("Y"); ?> <strong>Inventaris App</strong>.
            <span class="mx-1 opacity-25">|</span>
            Dibuat dengan <span style="color: #ef4444;">&hearts;</span> oleh <span class="text-primary fw-medium">Labib Abdullah</span>.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // --- Dark Mode Logic ---
    const html = document.documentElement;
    const iconSun = document.getElementById('icon-sun');
    const iconMoon = document.getElementById('icon-moon');

    /**
     * Fungsi untuk mengatur ikon (Matahari/Bulan)
     */
    function updateIcons(theme) {
        if (theme === 'dark') {
            if (iconSun) iconSun.classList.remove('d-none');
            if (iconMoon) iconMoon.classList.add('d-none');
        } else {
            if (iconSun) iconSun.classList.add('d-none');
            if (iconMoon) iconMoon.classList.remove('d-none');
        }
    }

    /**
     * Fungsi Toggle (Dipanggil saat tombol diklik di header)
     */
    function toggleTheme() {
        const currentTheme = html.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcons(newTheme);
    }

    // Inisialisasi Ikon saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = html.getAttribute('data-bs-theme') || 'light';
        updateIcons(savedTheme);
    });

    // --- SweetAlert Notification Logic ---
    // Menangkap session flash data dari PHP dan menampilkannya
    <?php if (isset($_SESSION['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $_SESSION['success']; ?>',
            timer: 3000,
            showConfirmButton: false,
            confirmButtonColor: '#2563eb',
            background: html.getAttribute('data-bs-theme') === 'dark' ? '#1e293b' : '#ffffff',
            color: html.getAttribute('data-bs-theme') === 'dark' ? '#f8fafc' : '#334155'
        });
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= $_SESSION['error']; ?>',
            confirmButtonColor: '#2563eb',
            background: html.getAttribute('data-bs-theme') === 'dark' ? '#1e293b' : '#ffffff',
            color: html.getAttribute('data-bs-theme') === 'dark' ? '#f8fafc' : '#334155'
        });
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
</script>

</body>

</html>