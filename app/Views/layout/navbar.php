<?php

$session = session();
$role = $session->get('role');
$user = $session->get('user');

?>

<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">Bank Sampah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
                </li>
                <?php if (in_array($role, ['teller', 'nasabah'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url($role . '/ubah/' . $user['id']) ?>">
                            Profile
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($role == 'admin') : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('kategori') ?>">List</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('kategori/tambah') ?>">Tambah</a></li>
                        </ul>
                    </li>
                <?php elseif (in_array($role, ['teller', 'nasabah'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('kategori') ?>">
                            Kategori
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array($role, ['admin', 'teller'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Nasabah
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('nasabah') ?>">List</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('nasabah/tambah') ?>">Tambah</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($role == 'admin') : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Teller
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('teller') ?>">List</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('teller/tambah') ?>">Tambah</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (in_array($role, ['admin', 'teller'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Setoran
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('setoran') ?>">List</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('setoran/tambah') ?>">Tambah</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('setoran/export/pdf') ?>">Export PDF</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('setoran/export/excel') ?>">Export Excel</a></li>
                        </ul>
                    </li>
                <?php elseif ($role == 'nasabah') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('setoran') ?>">
                            Setoran
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array($role, ['admin', 'teller'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Penarikan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('penarikan') ?>">List</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('penarikan/tambah') ?>">Tambah</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('penarikan/export/pdf') ?>">Export PDF</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('penarikan/export/excel') ?>">Export Excel</a></li>
                        </ul>
                    </li>
                <?php elseif ($role == 'nasabah') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('penarikan') ?>">
                            Penarikan
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_array($role, ['admin', 'teller'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('export') ?>">
                            Export
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex justify-content-end" role="search">
                <?php if (!$role) : ?>
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-light text-primary me-2" type="button">Login</a>
                <?php else : ?>
                    <form action="<?= base_url('auth/logout') ?>" method="POST">
                        <button class="btn btn-light text-primary me-2">Logout</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>