<div class="container py-5 fade-up">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <span class="badge <?= $audit['status'] == 'Aktif' ? 'bg-primary' : 'bg-success' ?> mb-2"><?= $audit['status'] ?></span>
            <h3 class="fw-bold">Laporan: <?= htmlspecialchars($audit['judul']) ?></h3>
        </div>
        <div class="d-flex gap-2">
            <?php if ($audit['status'] == 'Aktif'): ?>
                <a href="index.php?page=audit&act=close&id=<?= $audit['id'] ?>"
                    onclick="return confirm('Yakin ingin menutup audit ini? User tidak akan bisa mengedit lagi.')"
                    class="btn btn-outline-danger d-flex align-items-center gap-2">
                    <i class="bi bi-lock-fill"></i> Tutup Audit
                </a>
            <?php endif; ?>
            <a href="index.php?page=audit" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
    </div>

    <div class="card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Barang</th>
                        <th>Hasil Cek</th>
                        <th>Catatan</th>
                        <th>Dicek Oleh</th>
                        <th class="pe-4 text-end">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="ps-4 fw-medium"><?= htmlspecialchars($item['nama_barang']) ?></td>
                            <td>
                                <?php
                                $badge = match ($item['status_fisik']) {
                                    'Ada Baik' => 'success',
                                    'Ada Rusak' => 'warning',
                                    'Hilang' => 'danger',
                                    default => 'secondary'
                                };
                                ?>
                                <span class="badge bg-<?= $badge ?> bg-opacity-10 text-<?= $badge ?> border border-<?= $badge ?>">
                                    <?= $item['status_fisik'] ?>
                                </span>
                            </td>
                            <td class="text-muted small fst-italic"><?= $item['catatan'] ?: '-' ?></td>
                            <td class="small"><?= $item['checker_name'] ?: '-' ?></td>
                            <td class="pe-4 text-end small text-muted"><?= $item['checked_at'] ? date('H:i, d/m/y', strtotime($item['checked_at'])) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>