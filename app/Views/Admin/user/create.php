<?= $this->extend('template/admin') ?>


<?= $this->section('content') ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>Add user</h1>
</div>

<?php if (isset($errors)) : ?>
    <div class="alert alert-warning">
        <?= $errors->listErrors() ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('/users') ?>" method="post" class="w-50">
    <div class="mb-3">
        <label for="name" class="form-label">FullName</label>
        <input type="text" name="fullName" class="form-control">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3 ">
        <label for="name" class="form-label">Role</label>
        <select class="form-select w-50" name="role_id">
            <option selected>select a role</option>
            <?php foreach ($roles as $role) : ?>
                <option value="<?= $role->id ?>"><?= $role->name ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="active">
            <label class="form-check-label" for="active"> activer</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



<?= $this->endSection() ?>