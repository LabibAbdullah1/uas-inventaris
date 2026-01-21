<div class="container py-5 fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Audit & Stock Opname</h2>
            <p class="text-muted small mb-0">Pengecekan fisik aset secara berkala.</p>
        </div>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="index.php?page=audit&act=create" class="btn btn-primary-custom d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Buat Tugas
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($audits)): ?>
        <div class="text-center py-5">
            <div class="mb-3 text-secondary opacity-25">
                <i class="bi bi-clipboard-x" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-muted">Belum ada tugas audit.</h5>
            <?php if ($_SESSION['role'] != 'admin'): ?>
                <p class="small text-muted">Tunggu admin memberikan tugas kepada Anda.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($audits as $row): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card-custom p-4 h-100 position-relative border-start border-4 <?= $row['status'] == 'Aktif' ? 'border-primary' : 'border-success' ?>">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge <?= $row['status'] == 'Aktif' ? 'bg-primary' : 'bg-success' ?> bg-opacity-10 text-body border">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                            <small class="text-muted">
                                <?= date('d M Y', strtotime($row['created_at'])) ?>
                            </small>
                        </div>

                        <h5 class="fw-bold mb-1"><?= htmlspecialchars($row['judul']) ?></h5>
                        <p class="text-secondary small mb-3">
                            <i class="bi bi-calendar-event me-1"></i>
                            <?= date('d M', strtotime($row['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($row['tanggal_selesai'])) ?>
                        </p>

                        <div class="mb-3 p-3 rounded-3 border">
                            <div class="small text-secondary mb-1 d-flex align-items-center">
                                <i class="bi bi-person me-2 text-primary"></i>
                                <span>Petugas: <strong><?= htmlspecialchars($row['petugas'] ?? 'Belum ada') ?></strong></span>
                            </div>
                            <div class="small text-secondary d-flex align-items-center">
                                <i class="bi bi-tag me-2 text-primary"></i>
                                <span>Target: <strong><?= htmlspecialchars($row['nama_kategori'] ?? 'Semua Kategori') ?></strong></span>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-10 my-3">

                        <div class="d-grid mt-auto">
                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                <a href="index.php?page=audit&act=check&id=<?= $row['id'] ?>" class="btn btn-outline-custom btn-sm">
                                    <i class="bi bi-file-earmark-text me-1"></i> Lihat Laporan
                                </a>
                            <?php else: ?>
                                <?php if ($row['status'] == 'Aktif'): ?>
                                    <a href="index.php?page=audit&act=check&id=<?= $row['id'] ?>" class="btn btn-primary-custom btn-sm">
                                        <i class="bi bi-clipboard-check me-1"></i> Mulai Cek
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="bi bi-check-circle me-1"></i> Selesai
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>