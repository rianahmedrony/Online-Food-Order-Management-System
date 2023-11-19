<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/pagehead.php';
$title = 'Tell us something';
include $root . "/inc/header.php"; ?>
</head>

<body>
    <?php include $root . "/inc/navbar.php"; ?>
    <div class="container-md my-4">
        <h1 class="text-center my-3">Tell us something</h1>
        <div class="card">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col-12 col-md-6 text-center">
                        <img src="/assets/images/contact.svg" alt="" class="w-75 m-auto">
                    </div>
                    <div class="col-12 col-md-6">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" name="name" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="text" name="name" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" name="" id="message" cols="30" rows="10" required></textarea>
                            </div>
                            <button class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include $root . "/inc/footer.php"; ?>
</body>

</html>