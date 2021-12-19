<?= $this->extend('template/layout') ?>


<?= $this->section('content') ?>


<div class="row justify-content-md-center mt-5">
    <span class="h5">Contact us</span>

    <form action="<?= base_url('/contact') ?>" method="post" class="w-50">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control">
        </div>
        <div class="mb-3 ">
            <label class="form-label" for="description">Your comment</label>
            <textarea class="form-control" name="message" aria-label="With textarea"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?= $this->endSection() ?>