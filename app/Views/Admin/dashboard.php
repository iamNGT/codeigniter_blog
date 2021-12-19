<?= $this->extend('template/admin') ?>


<?= $this->section('content') ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>Dashboard</h1>
</div>

<span class="h4">
    welcome,your are connected as : <?= session()->get('name') ?>
</span>

<?= $this->endSection() ?>