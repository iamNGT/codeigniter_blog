<?= $this->extend('template/layout') ?>


<?= $this->section('content') ?>

<div class="container mt-5">
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
            <small class="text-muted">
                <span class="h6 text-indigo-400">Writen by <?= $writer ?> on <?= $post->created_at ?></span>
            </small>
        </div>

        <p class="my-5 bg-light rounded">
            <?= $post->description ?>
        </p>

        <hr class="bg-secondary">
        <p>Comments:</p>
        <?php if ($comments) : ?>
            <?php foreach ($comments as $key => $comment) : ?>
                <p class="text-muted">
                    <?= $comment->name ?> : <?= $comment->description ?>
                </p>
            <?php endforeach ?>
        <?php else: ?>
            no comments
        <?php endif ?>
        <div class="w-100"></div>

        <button type="submit" id="commentBtn" class="btn btn-primary">Add a Comment</button>

        <form action="" method="post" class="invisible w-50" id="commentForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Pseudo</label>
                <input type="name" name="name" class="form-control">
                <input type="hidden" name="post_id" value="<?= esc($post->id) ?>">
            </div>
            <div class="mb-3 ">
                <label class="form-label" for="description">Your comment</label>
                <textarea class="form-control" name="description" aria-label="With textarea"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
<script>
    $(function() {
        var addBtn = $("#commentBtn");
        addBtn.on('click', () => {
            $("#commentForm").removeClass("invisible")
            $("#commentForm").toggleClass("visible")
        });

        $('#commentForm').on('submit', function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('/comment') ?>",
                type: "POST",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.success == true) {
                        Swal.fire('Saved!', '', 'success')
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error at add data');
                }
            });

            $("#commentForm").removeClass("visible")
            $("#commentForm").toggleClass("invisible")
        });
    })
</script>

<?= $this->endSection() ?>