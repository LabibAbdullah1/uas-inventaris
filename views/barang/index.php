<div class="container py-5 fade-up">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Daftar Inventaris</h2>
            <p class="text-muted small mb-0">Kelola data aset dan barang universitas.</p>
        </div>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="d-flex gap-2">
                <a href="index.php?page=barang&act=export" target="_blank" class="btn btn-outline-secondary d-flex align-items-center gap-2 btn-sm px-3">
                    <i class="bi bi-printer"></i> Export PDF
                </a>
                <a href="index.php?page=barang&act=create" class="btn btn-primary-custom d-flex align-items-center gap-2 btn-sm px-3">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary small text-uppercase fw-bold">No</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Nama Barang</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Kategori</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Jumlah</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Kondisi</th>
                        <th class="py-3 text-secondary small text-uppercase fw-bold">Keterangan</th>
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <th class="text-end px-4 py-3 text-secondary small text-uppercase fw-bold">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($barang)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                Belum ada data barang.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($barang as $row): ?>
                            <tr>
                                <td class="px-4 text-muted small"><?= $no++ ?></td>
                                <td class="fw-medium"><?= htmlspecialchars($row['nama_barang']) ?></td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill fw-normal">
                                        <?= htmlspecialchars($row['nama_kategori']) ?>
                                    </span>
                                </td>
                                <td><?= $row['jumlah'] ?> Unit</td>
                                <td>
                                    <?php
                                    $bg = match ($row['kondisi']) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?= $bg ?> bg-opacity-10 text-<?= $bg ?> border border-<?= $bg ?> rounded-pill fw-normal">
                                        <?= $row['kondisi'] ?>
                                    </span>
                                </td>
                                <td class="text-muted small"><?= $row['keterangan'] ?></td>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                    <td class="text-end px-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="index.php?page=barang&act=edit&id=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="index.php?page=barang&act=delete&id=<?= $row['id'] ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin ingin menghapus <?= $row['nama_barang'] ?>?')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>