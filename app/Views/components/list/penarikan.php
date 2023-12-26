<?php

$session = session();
$role = $session->get('role');

$status_color = [
    'pending' => 'text-warning',
    'diterima' => 'text-success',
    'ditolak' => 'text-danger',
]

?>

<div class="card">
    <h3 class="card-header">
        Penarikan
        <?php if (in_array($role, ['nasabah'])) : ?>
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
                        <th scope="col">Bank</th>
                        <th scope="col">Nomor Rekening</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Tanggal Penarikan</th>
                        <th scope="col">Tanggal Diproses</th>
                        <th scope="col">Status</th>
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
                            <td><?= $penarikan['bank'] ?></td>
                            <td><?= str_pad(substr($penarikan['nomor_rekening'], -4), strlen($penarikan['nomor_rekening']), "*", STR_PAD_LEFT) ?></td>
                            <td><?= number_to_currency($penarikan['nominal'], 'IDR', 'id_ID'); ?></td>
                            <td><?= $penarikan['tanggal_pengajuan']; ?></td>
                            <?php if ($penarikan['status'] == 'pending') : ?>
                                <td class="text-secondary">Belum Diproses</td>
                            <?php else : ?>
                                <td><?= $penarikan['tanggal_diproses']; ?></td>
                            <?php endif; ?>
                            <td>
                                <?php if ($role === 'admin' && $penarikan['status'] === 'pending') : ?>
                                    <form method="POST" action="<?= base_url('penarikan/proses/' . $penarikan['id']) ?>">
                                        <button type="submit" name="action" value="diterima" class="btn btn-sm btn-success">Terima</button>
                                        <button type="submit" name="action" value="ditolak" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                <?php else : ?>
                                    <span class="text-capitalize <?= $status_color[$penarikan['status']] ?>"><?= $penarikan['status'] ?></span>
                                <?php endif; ?>
                            </td>

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