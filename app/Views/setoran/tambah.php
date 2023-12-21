<?php

$session = session();
$role = $session->get('role');
$logged_in_user = $session->get('user');

?>

<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container" style="max-width:640px">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center py-4">
                Pembuatan Setoran Baru
            </h2>
            <form action="<?= base_url('setoran/tambah') ?>" method="POST" class="mx-auto">
                <div class="mb-3">
                    <label for="id_nasabah" class="form-label">Nasabah</label>
                    <select id="id_nasabah" name="id_nasabah" class="form-select">
                        <?php foreach ($nasabah_list as $nasabah) : ?>
                            <option value="<?= $nasabah['id'] ?>"><?= $nasabah['nama_lengkap'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <?php
                    // Jika yang login adalah seorang teller, maka teller tidak dapat memilih teller lain
                    // Jika yang login adalah seorang admin, maka admin dapat memilih teller lain
                    if ($role == 'teller') :
                    ?>
                        <input type="hidden" name="id_teller" value="<?= $logged_in_user['id'] ?>">
                    <?php else : ?>
                        <label for="id_teller" class="form-label">Teller</label>
                        <select id="id_teller" name="id_teller" class="form-select">
                            <?php foreach ($teller_list as $teller) : ?>
                                <option value="<?= $teller['id'] ?>"><?= $teller['nama_lengkap'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="id_kategori_sampah" class="form-label">Kategori Sampah</label>
                    <select id="id_kategori_sampah" name="id_kategori_sampah" class="form-select">
                        <?php foreach ($kategori_sampah_list as $kategori) : ?>
                            <option value="<?= $kategori['id'] ?>">
                                <?= $kategori['nama'] . ' (Rp. ' . $kategori['taksiran'] . ')' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="berat" class="form-label">Berat (kg)</label>
                    <input type="number" id="berat" name="berat" placeholder="Berat" class="form-control" min="0" required>
                </div>
                <button class="btn btn-primary w-100">Buat Setoran</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>