<?= $this->extend('template/layout') ?>


<?= $this->section('content') ?>

<div class="container mt-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="link-secondary">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="link-secondary" href="<?= base_url('/post/' . $post->slug) ?>">
                    <?= $post->title ?>
                </a>
            </li>
        </ol>
    </nav>
    <div class="container-fluid px-5 mx-auto my-5">
        <?php if (session()->get('msg')) : ?>
            <div class="alert alert-success">
                <?= session()->get('msg')  ?>
            </div>
        <?php endif; ?>
        <span class="h2 mb-5"><?= $post->title ?></span>
        <div class="d-flex flex-column my-3">
            <img src="<?= base_url('/' . $post->img_dir) ?>" class="img-fluid" alt="..." width="760" height="570">
            <small class="text-muted">
                <span class="h6">Writen by <?= $writer ?> on <?= $post->created_at ?> ,</span>
            </small>
            <small class="text-muted text-primary"> Tags:
                <?php foreach ($tags as $item) : ?>
                    <span class="badge bg-info"><?= $item->name ?></span>
                <?php endforeach ?>
            </small>
            <small class="text-muted">
                <span class="h6">Like: <?= $post->like ?> like | <?= $post->unlike ?> unlike ,</span>
            </small>
        </div>

        <p class="my-5 bg-light rounded">
            <?= $post->description ?>
        </p>

        <div class="d-flex justify-content-center">
            <form action="<?= base_url('/like/' . $post->slug) ?>" method="post">
                <input type="hidden" name="id" value="<?= $post->id ?>">
                <input type="hidden" name="like" value="<?= $post->like ?>">
                <button type="submit" class="btn btn-primary">
                    Like the post
                </button>
            </form>
            <form action="<?= base_url('/unlike/' . $post->slug) ?>" method="post">
                <input type="hidden" name="id" value="<?= $post->id ?>">
                <input type="hidden" name="unlike" value="<?= $post->unlike ?>">
                <button type="submit" class="btn btn-danger">
                    Unlike the post
                </button>
            </form>
        </div>

        <hr class="bg-secondary">
        <p>Comments:</p>
        <div id="results">

        </div>
        <div class="w-100"></div>

        <button type="submit" id="commentBtn" class="btn btn-primary">Add a Comment</button>

        <form action="" method="post" class="invisible w-50" id="commentForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Pseudo</label>
                <input type="name" name="name" id="name" class="form-control">
                <input type="hidden" name="post_id" value="<?= esc($post->id) ?>">
            </div>
            <div class="mb-3 ">
                <label class="form-label" for="description">Your comment</label>
                <textarea class="form-control" id="description" name="description" aria-label="With textarea"></textarea>
            </div>
            <button type="submit" id="submitCommentForm" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(function() {
        var addBtn = $("#commentBtn");
        addBtn.on('click', () => {
            $("#commentForm").removeClass("invisible")
            $("#commentForm").toggleClass("visible")
        });

        reloadTable()

        function reloadTable() {
            $.ajax({
                url: "<?= base_url('/allComment/' . $post->id) ?>",
                type: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function(res) {
                    $('#results').html('Fetching ...');
                },
                success: function(data) {
                    $('#results').html(data);
                }
            })
        }

        $('#submitCommentForm').on('click', function(e) {

            e.preventDefault();
            $.ajax({
                url: "<?= base_url('/countComment/' . $post->id) ?>",
                type: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(data) {
                    count = data.count
                    if (data.count < 3) {

                        $.ajax({
                            url: "<?php echo site_url('/comment') ?>",
                            type: "POST",
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            data: $('#commentForm').serialize(),
                            processData: false,
                            contentType: false,
                            dataType: "JSON",
                            success: function(data) {
                                if (data.success == true) {
                                    toastr.success(data.msg, "success")
                                    setInterval(reloadTable(),1000)
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Error at add data');
                            }
                        });
                    } else {
                        toastr.warning('the number of comments of this post has been reached', 'Sorry')
                    }
                }
            })



            $("#commentForm").removeClass("visible")
            $("#commentForm").toggleClass("invisible")
        });
    })
</script>

<?= $this->endSection() ?>