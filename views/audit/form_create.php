<div class="container py-5 fade-up">
    <div class="card-custom p-4 mw-100 mx-auto" style="max-width: 600px;">
        <h4 class="fw-bold mb-4">Buat Tugas Audit Baru</h4>
        <form action="<?= $action ?>" method="POST">

            <div class="mb-3">
                <label class="form-label small text-uppercase fw-bold text-secondary">Judul Kegiatan</label>
                <input type="text" name="judul" class="form-control" placeholder="Contoh: Audit Elektronik Lab 1" required>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label small text-uppercase fw-bold text-secondary">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label small text-uppercase fw-bold text-secondary">Batas Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label small text-uppercase fw-bold text-secondary">Tugaskan Kepada</label>
                    <select name="assigned_to" class="form-select" required>
                        <option value="">-- Pilih Petugas --</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id'] ?>">
                                <?= htmlspecialchars($u['nama_lengkap']) ?> (<?= ucfirst($u['role']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label small text-uppercase fw-bold text-secondary">Filter Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text small">Kosongkan jika ingin audit semua barang.</div>
                </div>
            </div>

            <div class="alert alert-info small mt-2">
                <i class="bi bi-info-circle me-1"></i>
                Sistem hanya akan mengambil data barang sesuai kategori yang dipilih.
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="index.php?page=audit" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary-custom">Buat Tugas</button>
            </div>
        </form>
    </div>
</div>