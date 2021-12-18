<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<div class="row mt-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mt-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="link-secondary">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="link-secondary" href="<?= base_url('/category/' . $category->name . '/' . $category->id) ?>">
                    <?= $category->name ?>
                </a>
            </li>
        </ol>
    </nav>

    <h1>Category : <?= $category->name ?></h1>
    <?php foreach ($posts as $item) : ?>
        <div class="col-12 col-md-3 m-3">
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