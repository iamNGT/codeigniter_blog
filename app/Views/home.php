<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
</nav>

<h1>Hello World!</h1>
<?php foreach ($posts as $item) : ?>
    <div class="col-12 col-md-3 m-3">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top " src="<?= base_url($item->img_dir) ?>" alt="">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $item->title ?>
                </h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="<?= base_url('/post/'.$item->slug) ?>" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>