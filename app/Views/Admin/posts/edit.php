<?= $this->extend('template/admin') ?>


<?= $this->section('content') ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1>Add post</h1>
</div>

<?php if (isset($errors)) : ?>
    <div class="alert alert-warning">
        <?= $errors->listErrors() ?>
    </div>
<?php endif; ?>

<?php if (session()->get('error')) : ?>
    <div class="alert alert-warning">
        <?= session()->get('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('/posts/update/' . $post->id) ?>" method="post" class="w-50" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= $post->title ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Image</label>
        <input type="file" name="img" class="form-control">
    </div>
    <div class="mb-3 ">
        <label for="name" class="form-label">Tag</label>
        <select class="form-select w-50" name="tags[]" multiple>
            <?php foreach ($tags as $tag) : ?>
                <option value="<?= $tag->id ?>"><?= $tag->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3 ">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control" id="description" value="<?= $post->description ?>" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



<?= $this->endSection() ?>