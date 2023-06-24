<?php

$session = session();
$role = $session->get('role');

?>

<div class="card">
    <h3 class="card-header">
        Teller
        <?php if ($role == 'admin') : ?>
            <a href="<?= base_url('nasabah/tambah') ?>" class="btn btn-primary">Tambah</a>
        <?php endif; ?>
    </h3>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="align-middle">
                    <tr>
                        <th scope="col">#</th>
                        <?php if ($role == 'admin') : ?>
                            <th scope="col">ID</th>
                        <?php endif; ?>
                        <th scope="col">Username</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor Telepon</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tanggal Daftar</th>
                        <th scope="col">Terakhir Login</th>
                        <th scope="col">Is Active</th>
                        <th scope="col">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teller_list as $i => $teller) : ?>
                        <tr>
                            <th scope="row"><?= $i + 1 ?></th>
                            <?php if ($role == 'admin') : ?>
                                <td><?= $teller['id']; ?></td>
                            <?php endif; ?>
                            <td><?= $teller['username']; ?></td>
                            <td><?= $teller['nama_lengkap']; ?></td>
                            <td><?= $teller['alamat']; ?></td>
                            <td><?= $teller['nomor_telepon']; ?></td>
                            <td><?= $teller['email']; ?></td>
                            <td><?= $teller['tanggal_daftar']; ?></td>
                            <td><?= $teller['terakhir_login']; ?></td>
                            <td><?= $teller['is_active'] ? 'Aktif' : 'Nonaktif'; ?></td>
                            <td>
                                <a href="<?= base_url('teller/ubah/') . $teller['id']; ?>" class="btn btn-outline-warning">Ubah</a>
                                <a href="<?= base_url('teller/hapus/') . $teller['id']; ?>" onclick="return confirm('Kamu yakin akan menghapus <?= $title . ' ' . $teller['nama_lengkap']; ?> ?');" class="btn btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (current_url() == base_url()) :  ?>
        <div class="card-footer text-center">
            <a href="<?= base_url('teller') ?>">Full</a>
        </div>
    <?php endif;  ?>


</div>