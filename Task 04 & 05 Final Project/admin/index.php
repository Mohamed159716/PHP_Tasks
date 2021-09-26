<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/layout/header.php');



?>

<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Admin Dashboard</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Banner Ends Here -->

<div class="container">
    <div class="row my-5">
        <div class="col-sm-6 d-flex justify-content-center">
            <a href="<?php echo BASE_URL . '/admin/posts.php' ?>" class="btn btn-primary">Show all Posts</a>
        </div>
        <div class="col-sm-6">
            <a href="<?php echo BASE_URL . '/admin/users.php' ?>" class="btn btn-primary">Show all Users</a>
        </div>
    </div>
</div>



<?php require_once(BASE_PATH . '/layout/footer.php') ?>