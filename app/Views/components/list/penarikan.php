<?php

$session = session();
$role = $session->get('role');

?>

<div class="card">
    <h3 class="card-header">
        Penarikan
        <?php if (in_array($role, ['admin', 'teller'])) : ?>
            <a href="<?= base_url('penarikan/tambah') ?>" class="btn btn-sm btn-primary">Tambah</a>
        <?php endif; ?>
    </h3>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <?php if (in_array($role, ['admin', 'teller'])) : ?>
                            <th scope="col">Nasabah</th>
                        <?php endif; ?>
                        <?php if (in_array($role, ['admin', 'nasabah'])) : ?>
                            <th scope="col">Teller</th>
                        <?php endif; ?>
                        <th scope="col">Nominal</th>
                        <th scope="col">Tanggal Penarikan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penarikan_list as $i => $penarikan) : ?>
                        <tr>
                            <th scope="row"><?= $i + 1 ?></th>
                            <td><?= $penarikan['id']; ?></td>
                            <?php if (in_array($role, ['admin', 'teller'])) : ?>
                                <td><?= $penarikan['nasabah_nama_lengkap'] ?? 'NULL'; ?></td>
                            <?php endif; ?>
                            <?php if (in_array($role, ['admin', 'nasabah'])) : ?>
                                <td><?= $penarikan['teller_nama_lengkap'] ?? 'NULL'; ?></td>
                            <?php endif; ?>
                            <td><?= number_to_currency($penarikan['nominal'], 'IDR', 'id_ID'); ?></td>
                            <td><?= $penarikan['tanggal_penarikan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (current_url() == base_url()) :  ?>
        <div class="card-footer text-center">
            <a href="<?= base_url('penarikan') ?>">Full</a>
        </div>
    <?php endif;  ?>
</div>