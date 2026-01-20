<div class="container py-5 fade-up">
    <div class="card-custom p-4 mw-100 mx-auto" style="max-width: 600px;">
        <h4 class="fw-bold mb-4">Buat Jadwal Audit Baru</h4>
        <form action="<?= $action ?>" method="POST">
            <div class="mb-3">
                <label class="form-label small text-uppercase fw-bold text-secondary">Judul Kegiatan</label>
                <input type="text" name="judul" class="form-control" placeholder="Misal: Audit Lab Q1 2026" required>
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
            <div class="alert alert-info small">
                <i class="bi bi-info-circle me-1"></i>
                Sistem akan otomatis menyalin (snapshot) semua data barang saat ini ke dalam jadwal audit ini.
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="index.php?page=audit" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary-custom">Buat Jadwal</button>
            </div>
        </form>
    </div>
</div>