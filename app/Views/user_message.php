<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Unactivated User Message</title>
    <style>
        button {
            border: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <span class="h5">Welcome</span>

                <p class="h6">
                    Sorry you can't continue,Your account has't been yet activated,
                    the admin has been notified
                </p>
                <form action="/logout" method="post">
                    <button type="submit" class="btn btn-secondary">
                        Sign out?
                    </button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>