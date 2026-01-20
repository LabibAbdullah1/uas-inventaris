<div class="container py-5 fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Audit & Stock Opname</h2>
            <p class="text-muted small mb-0">Pengecekan fisik aset secara berkala.</p>
        </div>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="index.php?page=audit&act=create" class="btn btn-primary-custom d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Buat Jadwal
            </a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php foreach ($audits as $row): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card-custom p-4 h-100 position-relative border-start border-4 <?= $row['status'] == 'Aktif' ? 'border-primary' : 'border-success' ?>">

                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge <?= $row['status'] == 'Aktif' ? 'bg-primary' : 'bg-success' ?> bg-opacity-10 text-body border">
                            <?= $row['status'] ?>
                        </span>
                        <small class="text-muted"><?= date('d M Y', strtotime($row['created_at'])) ?></small>
                    </div>

                    <h5 class="fw-bold mb-2"><?= htmlspecialchars($row['judul']) ?></h5>
                    <p class="text-secondary small mb-3">
                        <i class="bi bi-calendar-event me-1"></i>
                        <?= date('d M', strtotime($row['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($row['tanggal_selesai'])) ?>
                    </p>

                    <div class="d-grid">
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <a href="index.php?page=audit&act=check&id=<?= $row['id'] ?>" class="btn btn-outline-custom btn-sm">
                                <i class="bi bi-file-earmark-text me-1"></i> Lihat Laporan
                            </a>
                            <a href="index.php?page=audit&act=delete&id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm mt-2">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </a>
                        <?php else: ?>
                            <?php if ($row['status'] == 'Aktif'): ?>
                                <a href="index.php?page=audit&act=check&id=<?= $row['id'] ?>" class="btn btn-primary-custom btn-sm">
                                    <i class="bi bi-clipboard-check me-1"></i> Mulai Cek
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Sudah Selesai</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>