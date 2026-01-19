<div class="container py-5 fade-up">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="mb-4">
                <a href="index.php?page=barang" class="text-decoration-none text-muted small fw-bold">
                    &larr; KEMBALI KE DAFTAR
                </a>
            </div>

            <div class="card-custom p-4 p-md-5">
                <div class="mb-4">
                    <h4 class="fw-bold mb-1"><?= $title ?></h4>
                    <p class="text-muted small">Silakan lengkapi informasi barang di bawah ini.</p>
                </div>

                <form action="<?= $action ?>" method="POST">
                    <?php if (isset($barang['id'])): ?>
                        <input type="hidden" name="id" value="<?= $barang['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control"
                            value="<?= isset($barang['nama_barang']) ? $barang['nama_barang'] : '' ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <?php foreach ($kategori as $k):
                                    $selected = (isset($barang['kategori_id']) && $barang['kategori_id'] == $k['id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $k['id'] ?>" <?= $selected ?>><?= $k['nama_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="0"
                                value="<?= isset($barang['jumlah']) ? $barang['jumlah'] : '' ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <?php
                            $cond = isset($barang['kondisi']) ? $barang['kondisi'] : '';
                            ?>
                            <option value="Baik" <?= $cond == 'Baik' ? 'selected' : '' ?>>Baik</option>
                            <option value="Rusak Ringan" <?= $cond == 'Rusak Ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                            <option value="Rusak Berat" <?= $cond == 'Rusak Berat' ? 'selected' : '' ?>>Rusak Berat</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"><?= isset($barang['keterangan']) ? $barang['keterangan'] : '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php?page=barang" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4 shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>