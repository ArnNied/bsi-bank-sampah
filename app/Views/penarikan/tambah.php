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
                Pembuatan Penarikan Baru
            </h2>
            <form action="<?= base_url('penarikan/tambah') ?>" method="POST" class="mx-auto">
                <div class="mb-3">
                    <label for="saldo" class="form-label fw-bold">Saldo anda</label>
                    <input type="text" id="saldo" value="<?= $logged_in_user['saldo'] ?>" class="form-control" disabled readonly />
                </div>
                <div class="mb-3">
                    <label for="bank" class="form-label">Bank</label>
                    <select id="bank" name="bank" class="form-select">
                        <?php foreach ($bank_list as $bank) : ?>
                            <option value="<?= $bank ?>"><?= $bank ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                    <input type="text" id="nomor_rekening" name="nomor_rekening" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="nominal" class="form-label">Nominal <small class="text-secondary">(min: 10000)</small></label>
                    <input type="number" id="nominal" name="nominal" class="form-control" min="10000" max="<?= $logged_in_user['saldo'] ?>" />
                </div>
                <button class="btn btn-primary w-100">Buat Penarikan</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>