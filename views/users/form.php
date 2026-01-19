<div class="container py-5 fade-up">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="mb-4">
                <a href="index.php?page=user" class="text-decoration-none text-muted small fw-bold">
                    &larr; KEMBALI
                </a>
            </div>

            <div class="card-custom p-4 p-md-5">
                <div class="mb-4">
                    <h4 class="fw-bold mb-1"><?= $title ?></h4>
                    <p class="text-muted small">Kelola akses pengguna sistem.</p>
                </div>

                <form action="<?= $action ?>" method="POST">
                    <?php if (isset($user['id'])): ?>
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                            value="<?= isset($user['nama_lengkap']) ? $user['nama_lengkap'] : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Username</label>
                        <input type="text" name="username" class="form-control"
                            value="<?= isset($user['username']) ? $user['username'] : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="<?= isset($user['id']) ? 'Isi jika ingin ganti password' : 'Password baru' ?>"
                            <?= isset($user['id']) ? '' : 'required' ?>>
                    </div>

                    <div class="mb-5">
                        <label class="form-label small fw-bold text-uppercase text-muted">Role</label>
                        <select name="role" class="form-select">
                            <?php $role = isset($user['role']) ? $user['role'] : ''; ?>
                            <option value="user" <?= $role == 'user' ? 'selected' : '' ?>>User (Staff)</option>
                            <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin (Full Akses)</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary-custom shadow-sm">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>