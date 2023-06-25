<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container" style="max-width:640px">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center py-4">
                Login
            </h2>
            <form action="<?= base_url('auth/login') ?>" method="POST" class="mx-auto">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" class="form-control" autofocus required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Tipe</label>
                    <select id="role" name="role" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="teller">Teller</option>
                        <option value="nasabah" selected>Nasabah</option>
                    </select>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>