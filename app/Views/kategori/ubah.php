<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container" style="max-width:640px">
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="card-title text-center py-4">
                Ubah Kategori <?= $kategori['nama'] ?>
            </h2>
            <form action="<?= base_url('kategori/ubah/' . $kategori['id']) ?>" method="POST" class="mx-auto">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" placeholder="Nama Kategori" class="form-control" value="<?= $kategori['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi" class="form-control"><?= $kategori['deskripsi'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="taksiran" class="form-label">Taksiran (kg)</label>
                    <input type="number" id="taksiran" name="taksiran" placeholder="Taksiran (kg)" class="form-control" value="<?= $kategori['taksiran'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok (kg)</label>
                    <input type="number" id="stok" name="stok" placeholder="Stok (kg)" class="form-control" value="<?= $kategori['stok'] ?>" required>
                </div>
                <button class="btn btn-primary w-100">Ubah Kategori</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-center py-4">
                <b>HAPUS KATEGORI</b>
            </h4>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#hapus">
                HAPUS KATEGORI INI
            </button>
        </div>
    </div>
</div>

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
                <form action="<?= base_url('kategori/hapus/' . $kategori['id']) ?>" method="POST">
                    <button class="btn btn-danger w-100">Ya, Hapus Kategori Ini</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>