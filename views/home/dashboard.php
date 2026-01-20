<div class="container py-5 fade-up">
    <div class="mb-5">
        <h1 class="h3 fw-bold mb-1">Halo, <?= htmlspecialchars($_SESSION['nama']); ?>! 👋</h1>
        <p class="text-secondary">Selamat datang kembali di panel inventaris aset kampus.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card-custom p-4 h-100 position-relative overflow-hidden group-hover-effect">
                <div class="d-flex justify-content-between align-items-start position-relative z-2">
                    <div>
                        <p class="text-secondary small fw-bold text-uppercase mb-1">Total Barang</p>
                        <h2 class="display-5 fw-bold mb-0" style="color: var(--bs-body-color);"><?= $total_barang; ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px; background-color: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <a href="index.php?page=barang" class="stretched-link"></a>
            </div>
        </div>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card-custom p-4 h-100 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-start position-relative z-2">
                        <div>
                            <p class="text-secondary small fw-bold text-uppercase mb-1">Pengguna Sistem</p>
                            <h2 class="display-5 fw-bold mb-0" style="color: var(--bs-body-color);"><?= $total_user; ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <a href="index.php?page=user" class="stretched-link"></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card-custom p-4 h-100 d-flex flex-column justify-content-center gap-3">
                    <a href="index.php?page=barang&act=create" class="btn btn-primary-custom w-100 d-flex align-items-center justify-content-center gap-2">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Barang
                    </a>
                    <a href="index.php?page=barang&act=export" target="_blank"
                        class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Export Laporan
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="card-custom overflow-hidden">
        <div class="card-header border-bottom p-3 d-flex justify-content-between align-items-center"
            style="background-color: var(--bg-card); border-color: var(--border);">
            <h6 class="mb-0 fw-bold text-uppercase small text-secondary" style="letter-spacing: 0.05em;">Inventaris Terbaru</h6>
            <a href="index.php?page=barang" class="text-decoration-none small fw-medium hover-underline">Lihat Semua &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-secondary small text-uppercase fw-bold">Nama Barang</th>
                        <th class="text-secondary small text-uppercase fw-bold">Kategori</th>
                        <th class="text-secondary small text-uppercase fw-bold">Jumlah</th>
                        <th class="text-end pe-4 text-secondary small text-uppercase fw-bold">Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($barang_terbaru)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted small">Belum ada data barang.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($barang_terbaru as $brg): ?>
                            <tr>
                                <td class="ps-4 fw-medium"><?= htmlspecialchars($brg['nama_barang']); ?></td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill fw-normal">
                                        <?= htmlspecialchars($brg['nama_kategori']); ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($brg['jumlah']); ?> Unit</td>
                                <td class="text-end pe-4">
                                    <?php
                                    $bg = match ($brg['kondisi']) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?= $bg ?> bg-opacity-10 text-<?= $bg ?> border border-<?= $bg ?> rounded-pill fw-normal">
                                        <?= htmlspecialchars($brg['kondisi']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>