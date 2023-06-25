<?php

$session = session();
$role = $session->get('role');

?>

<div class="card">
    <h3 class="card-header">
        Setoran
        <?php if (in_array($role, ['admin', 'teller'])) : ?>
            <a href="<?= base_url('setoran/tambah') ?>" class="btn btn-sm btn-primary">Tambah</a>
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
                        <th scope="col">Kategori Sampah</th>
                        <th scope="col">Berat</th>
                        <th scope="col">Taksiran (kg)</th>
                        <th scope="col">Total</th>
                        <th scope="col">Tanggal Setor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($setoran_list as $i => $setoran) : ?>
                        <tr>
                            <th scope="row"><?= $i + 1 ?></th>
                            <td><?= $setoran['id']; ?></td>
                            <?php if (in_array($role, ['admin', 'teller'])) : ?>
                                <td><?= $setoran['nasabah_nama_lengkap'] ?? 'NULL'; ?></td>
                            <?php endif; ?>
                            <?php if (in_array($role, ['admin', 'nasabah'])) : ?>
                                <td><?= $setoran['teller_nama_lengkap'] ?? 'NULL'; ?></td>
                            <?php endif; ?>
                            <td><?= $setoran['kategori_sampah']; ?></td>
                            <td><?= $setoran['berat']; ?></td>
                            <td><?= number_to_currency($setoran['taksiran'], 'IDR', 'id_ID'); ?></td>
                            <td><?= number_to_currency(floor($setoran['berat'] * $setoran['taksiran']), 'IDR', 'id_ID'); ?></td>
                            <td><?= $setoran['tanggal_setor']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (current_url() == base_url()) :  ?>
        <div class="card-footer text-center">
            <a href="<?= base_url('setoran') ?>">Full</a>
        </div>
    <?php endif;  ?>
</div>