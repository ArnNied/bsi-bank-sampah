<?php

$session = session();
$role = $session->get('role');
$user = $session->get('user');

?>

<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row g-5">
        <div class="col-md-6">
            <div class="card">
                <h2 class="col-md-12 text-center my-4">
                    Halo, <?= $user['nama_lengkap'] ?>!
                </h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md py-2">
                            <div class="row text-center">
                                <h4 class="col-12"><?= $statistik['nasabah_baru'] ?></h4>
                                <h6 class="col-12 text-body-secondary">Nasabah Baru</h6>
                            </div>
                        </div>
                        <div class="col-md py-2">
                            <div class="row text-center">
                                <h4 class="col-12">
                                    <?= $statistik['setoran'] ?>
                                </h4>
                                <h6 class="col-12 text-body-secondary">Total Setoran Bulan Ini</h6>
                            </div>
                        </div>
                        <div class="col-md py-2">
                            <div class="row text-center">
                                <h4 class="col-12">
                                    <?= $statistik['penarikan'] ?>
                                </h4>
                                <h6 class="col-12 text-body-secondary">Total Penarikan Bulan Ini</h6>
                            </div>
                        </div>
                        <div class="col-md py-2">
                            <div class="row text-center">
                                <h4 class="col-12">
                                    <?= $statistik['berat'] ?>
                                </h4>
                                <h6 class="col-12 text-body-secondary">Total Berat Bulan Ini (kg)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?= $this->include('components/list/kategori') ?>
        </div>
        <div class="col-md-6">
            <?= $this->include('components/list/setoran') ?>
        </div>
        <div class="col-md-6">
            <?= $this->include('components/list/penarikan') ?>
        </div>
        <div class="col-md-12">
            <?= $this->include('components/list/nasabah') ?>
        </div>
        <div class="col-md-12">
            <?= $this->include('components/list/teller') ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>