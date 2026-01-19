<div class="container py-5 fade-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Pengguna</h2>
            <p class="text-muted small mb-0">Manajemen akun admin dan staff.</p>
        </div>
        <a href="index.php?page=user&act=create" class="btn btn-dark btn-sm px-3 d-flex align-items-center gap-2">
            <i class="bi bi-person-plus-fill"></i> Tambah User
        </a>
    </div>

    <div class="card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-secondary small text-uppercase">No</th>
                        <th class="py-3 text-secondary small text-uppercase">Nama Lengkap</th>
                        <th class="py-3 text-secondary small text-uppercase">Username</th>
                        <th class="py-3 text-secondary small text-uppercase">Role</th>
                        <th class="text-end px-4 py-3 text-secondary small text-uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($users as $u): ?>
                        <tr>
                            <td class="px-4 text-muted small"><?= $no++ ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($u['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td>
                                <span class="badge <?= $u['role'] == 'admin' ? 'bg-primary' : 'bg-secondary' ?> bg-opacity-10 text-body border fw-normal">
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="index.php?page=user&act=edit&id=<?= $u['id'] ?>"
                                        class="btn btn-sm btn-outline-secondary">Edit</a>

                                    <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                        <a href="index.php?page=user&act=delete&id=<?= $u['id'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-light text-muted" disabled>Hapus</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>