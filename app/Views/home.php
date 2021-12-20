<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>

<div class="row mt-5">
    <h3 class="h3 mt-5">Recent post : </h3>
    <?php foreach ($posts as $item) : ?>
        <div class="col-sm-3 col-md-3 m-3">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top " src="<?= base_url($item->img_dir) ?>" alt="">
                <div class="card-body">
                    <h6 class="card-title">
                        <?= $item->title ?>
                    </h6>
                    <p class="card-text">
                        <?= word_limiter($item->description, 5, '...') ?>
                    </p>
                    <a href="<?= base_url('/post/' . $item->slug) ?>" class="btn btn-primary">Read +</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>