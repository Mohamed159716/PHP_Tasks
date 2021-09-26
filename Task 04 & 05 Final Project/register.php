<?php
require_once('config.php');
require_once(BASE_PATH . '/helpers/requesthelper.php');
require_once(BASE_PATH . '/helpers/registervalidation.php');
require_once(BASE_PATH . '/logic/auth.php');

$data = '';
if (isset($_REQUEST['name']) || isset($_REQUEST['email'])) {
    $request = validateRequest();
    $data = $request['data'];
    $errors = $request['errors'];
    if (count($errors) == 0) {
        $success = tryRegister($_REQUEST['name'], $_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['phone']);

        header('Location: ' . BASE_URL . '/index.php');
    }
}



?>
<?php require_once(BASE_PATH . '/layout/header.php'); ?>
<section class="register">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <h2 class="text-center mb-4">Registration From</h2>
                <form method="POST" action="register.php" class="w-50 m-auto">
                    <div class="mb-3">
                        <input name="name" class=" form-control" placeholder="name" required
                            value="<?= getData($data, 'name') ?>" />
                        <?= isset($errors['name']) ? $errors['name'] : '' ?>
                    </div>
                    <div class="mb-3">
                        <input name="username" class=" form-control" placeholder="username" required
                            value="<?= getData($data, 'username') ?>" />
                        <?= isset($errors['username']) ? $errors['username'] : '' ?>
                    </div>
                    <div class="mb-3">
                        <input name="email" type="text" required class=" form-control" placeholder="email" />
                        <?= isset($errors['email']) ? $errors['email'] : '' ?>
                    </div>
                    <div class="mb-3">
                        <input name="password" type="password" required class=" form-control" placeholder="Password" />
                        <?= isset($errors['password']) ? $errors['password'] : '' ?>
                    </div>
                    <div class="mb-3">
                        <input name="confirm_password" type="password" required class=" form-control"
                            placeholder="Conform Password" />
                        <?= isset($errors['confirm_password']) ? $errors['confirm_password'] : '' ?>
                    </div>
                    <div class="mb-3">
                        <input name="phone" type="text" required class=" form-control" placeholder="phone"
                            value="<?= getData($data, 'phone') ?>" />
                    </div>
                    <span class="text text-danger"><?= isset($errors['generic']) ? $errors['generic'] : '' ?></span>

                    <button class="btn btn-success btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once(BASE_PATH . '/layout/footer.php') ?>