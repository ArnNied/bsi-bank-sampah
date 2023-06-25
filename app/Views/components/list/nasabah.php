<?php

$session = session();
$role = $session->get('role');

?>

<div class="card">
    <h3 class="card-header">
        Nasabah
        <?php if (in_array($role, ['admin', 'teller'])) : ?>
            <a href="<?= base_url('nasabah/tambah') ?>" class="btn btn-sm btn-primary">Tambah</a>
        <?php endif; ?>
    </h3>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <?php if (in_array($role, ['admin', 'teller'])) : ?>
                            <th scope="col">ID</th>
                        <?php endif; ?>
                        <th scope="col">Username</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor Telepon</th>
                        <th scope="col">Email</th>
                        <th scope="col">Saldo</th>
                        <th scope="col">Tanggal Daftar</th>
                        <th scope="col">Terakhir Login</th>
                        <th scope="col">Is Active</th>
                        <?php if (in_array($role, ['admin', 'teller'])) : ?>
                            <th scope="col">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nasabah_list as $i => $nasabah) : ?>
                        <tr>
                            <th scope="row"><?= $i + 1 ?></th>
                            <?php if (in_array($role, ['admin', 'teller'])) : ?>
                                <td><?= $nasabah['id']; ?></td>
                            <?php endif; ?>
                            <td><?= $nasabah['username']; ?></td>
                            <td><?= $nasabah['nama_lengkap']; ?></td>
                            <td><?= $nasabah['alamat']; ?></td>
                            <td><?= $nasabah['nomor_telepon']; ?></td>
                            <td><?= $nasabah['email']; ?></td>
                            <td><?= number_to_currency($nasabah['saldo'], 'IDR', 'id_ID'); ?></td>
                            <td><?= $nasabah['tanggal_daftar']; ?></td>
                            <td><?= $nasabah['terakhir_login']; ?></td>
                            <td><?= $nasabah['is_active'] ? 'Aktif' : 'Nonaktif'; ?></td>
                            <?php if (in_array($role, ['admin', 'teller'])) : ?>
                                <td>
                                    <a href="<?= base_url('nasabah/ubah/') . $nasabah['id']; ?>" class="btn btn-warning">Ubah</a>
                                    <?php if ($role == 'admin') : ?>

                                        <form method="POST" action="<?= base_url('nasabah/hapus/') . $nasabah['id']; ?>" style="display: inline">
                                            <button class="btn btn-outline-danger" onclick="return confirm('Kamu yakin akan menghapus <?= $title . ' ' . $nasabah['nama_lengkap']; ?> ?');">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (current_url() == base_url()) :  ?>
        <div class="card-footer text-center">
            <a href="<?= base_url('nasabah') ?>">Full</a>
        </div>
    <?php endif;  ?>
</div>