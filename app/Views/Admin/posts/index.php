<?= $this->extend('template/admin') ?>


<?= $this->section('content') ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>Lists of all posts</h1>
    <a href="<?= base_url('/posts/new') ?>" class="btn btn-primary">Add posts</a>
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
                <th scope="col">Title</th>
                <th scope="col">Created at</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) :  ?>
                <tr>
                    <td> <?= $post->id ?> </td>
                    <td><?= $post->title ?></td>
                    <td><?= $post->created_at ?></td>
                    <td>
                        <a href="<?= base_url('/posts/' . $post->id . '/edit') ?>" class="btn btn-primary">Edit</a>
                        <form action="<?= base_url('/posts/delete/' . $post->id) ?>" method="post" onsubmit="return confirm('are you sure')">
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