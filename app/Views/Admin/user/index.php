<?= $this->extend('template/admin') ?>


<?= $this->section('content') ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>Lists of all users</h1>
    <a href="<?= base_url('/users/new') ?>" class="btn btn-primary">Add user</a>
</div>

<?php if (session()->get('success')) : ?>
    <div class="alert alert-success">
        <?= session()->get('success')  ?>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) :  ?>
                <tr>
                    <td> <?= $user->id ?> </td>
                    <td><?= $user->fullName ?></td>
                    <td><?= $user->email ?></td>
                    <td>
                        <?= $user->active == 1 ? '<span class="badge bg-info">active</span>' : '<span class="badge bg-danger">inactive</span>' ?>
                    </td>
                    <td><?= $user->role ?></td>
                    <td>
                        <a href="<?= base_url('/users/' . $user->id . '/edit') ?>" class="btn btn-primary">Edit</a>
                        <form action="<?= base_url('/users/delete/' . $user->id) ?>" method="post" onsubmit="return confirm('are you sure')">
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach  ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>