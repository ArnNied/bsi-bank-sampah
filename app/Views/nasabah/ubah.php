<?php

$session = session();
$role = $session->get('role');
$user = $session->get('user');

?>

<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container" style="max-width:640px">
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title text-center py-4">
                <?php if ($role == 'nasabah' && $user['id'] == $nasabah['id']) : ?>
                    Perbarui Profile
                <?php else : ?>
                    Perbarui Data Nasabah (<?= $nasabah['nama_lengkap'] ?>)
                <?php endif; ?>
            </h2>
            <form action="<?= base_url('nasabah/ubah/' . $nasabah['id']) ?>" method="POST" class="mx-auto">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?= $nasabah['username'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" value="<?= $nasabah['nama_lengkap'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" placeholder="Alamat" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" placeholder="Nomor Telepon: 1234-5678-9123" class="form-control" value="<?= $nasabah['nomor_telepon'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="<?= $nasabah['email'] ?>" required>
                </div>
                <?php if (in_array($role, ['admin', 'teller'])) : ?>
                    <div class="mb-3">
                        <?php if ($nasabah['is_active']) : ?>
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <?php else : ?>
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active">
                        <?php endif; ?>
                        <label class="form-check-label" for="is_active">
                            Is Active
                        </label>
                    </div>
                <?php endif; ?>
                <button class="btn btn-primary w-100">Perbarui Data</button>
            </form>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title text-center py-4">
                Ganti Password
            </h2>
            <form action="<?= base_url('nasabah/ubah/' . $nasabah['id'] . '/ganti-password') ?>" method="POST" class="mx-auto">
                <div class="mb-3">
                    <label for="password_lama" class="form-label">Password Lama</label>
                    <input type="password" id="password_lama" name="password_lama" placeholder="Password Lama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_baru" class="form-label">Password Baru</label>
                    <input type="password" id="password_baru" name="password_baru" placeholder="Password Baru" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" id="konfirmasi_password_baru" name="konfirmasi_password_baru" placeholder="Konfirmasi Password Baru" class="form-control" required>
                </div>
                <button class="btn btn-danger w-100">Perbarui Password</button>
            </form>
        </div>
    </div>

    <?php if ($role == 'admin') : ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center py-4">
                    <b>HAPUS AKUN</b>
                </h4>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#hapus">
                    HAPUS AKUN INI
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if ($role == 'admin') : ?>

    <!-- Modal -->
    <div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="hapusLabel">Apa Anda Yakin?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="<?= base_url('nasasbah/hapus/' . $nasabah['id']) ?>" method="POST">
                        <button class="btn btn-danger w-100">Ya, Hapus Akun Ini</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>