<?= $this->extend('template/layout') ?>


<?= $this->section('content') ?>

<div class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="link-secondary">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="link-secondary" href="<?= base_url('/category/' . $category->name . '/' . $category->id) ?>">
                    <?= $category->name ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="link-secondary" href="<?= base_url('/post/' . $post->slug) ?>">
                    <?= $post->title ?>
                </a>
            </li>
        </ol>
    </nav>
    <div class="container-fluid px-5 mx-auto my-5">
        <span class="h2 mb-5"><?= $post->title ?></span>
        <div class="d-flex flex-column my-3">
            <img src="<?= base_url('/' . $post->img_dir) ?>" class="img-fluid" alt="..." width="760" height="570">
            <span class="h6 text-indigo-400">Writen by <?= $writer ?> on <?= $post->created_at ?></span>
        </div>
    </div>
</div>


<?= $post->slug ?>
<?= $this->endSection() ?>