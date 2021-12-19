<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
        <div class="row justify-content-md-center mt-5">
            <div class="col-5">

                <h2>Login in</h2>

                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="post">
                    <div class="form-group mb-3">
                        <input type="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Signin</button>
                    </div>
                </form>
            </div>

        </div>
<?= $this->endSection() ?>