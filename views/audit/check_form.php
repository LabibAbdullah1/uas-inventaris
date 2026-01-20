<div class="container py-5 fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-primary mb-2">Mode Pengecekan</span>
            <h3 class="fw-bold"><?= htmlspecialchars($audit['judul']) ?></h3>
        </div>
        <a href="index.php?page=audit" class="btn btn-outline-secondary btn-sm">&larr; Kembali</a>
    </div>

    <form action="index.php?page=audit&act=submit_check" method="POST">
        <input type="hidden" name="audit_id" value="<?= $audit['id'] ?>">

        <div class="card-custom overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Barang</th>
                            <th>Kondisi Database</th>
                            <th>Status Fisik (Ceklis)</th>
                            <th class="pe-4">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold"><?= htmlspecialchars($item['nama_barang']) ?></div>
                                    <div class="small text-muted"><?= $item['nama_kategori'] ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-body border">
                                        <?= $item['kondisi_awal'] ?>
                                    </span>
                                </td>
                                <td style="min-width: 200px;">
                                    <select name="items[<?= $item['id'] ?>][status]" class="form-select form-select-sm border-primary">
                                        <option value="Belum Dicek" <?= $item['status_fisik'] == 'Belum Dicek' ? 'selected' : '' ?> class="text-muted">-- Belum --</option>
                                        <option value="Ada Baik" <?= $item['status_fisik'] == 'Ada Baik' ? 'selected' : '' ?> class="fw-bold text-success">✅ Ada (Baik)</option>
                                        <option value="Ada Rusak" <?= $item['status_fisik'] == 'Ada Rusak' ? 'selected' : '' ?> class="fw-bold text-warning">⚠️ Ada (Rusak)</option>
                                        <option value="Hilang" <?= $item['status_fisik'] == 'Hilang' ? 'selected' : '' ?> class="fw-bold text-danger">❌ Hilang</option>
                                    </select>
                                </td>
                                <td class="pe-4">
                                    <input type="text" name="items[<?= $item['id'] ?>][catatan]"
                                        class="form-control form-control-sm"
                                        value="<?= htmlspecialchars($item['catatan'] ?? '') ?>"
                                        placeholder="Keterangan...">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary-custom shadow-sm d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-check2-circle"></i> Submit Hasil Cek
            </button>
        </div>

        <div style="height: 80px;"></div>
    </form>
</div>