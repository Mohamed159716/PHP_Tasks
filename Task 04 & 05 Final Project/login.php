  <?php
  require_once('./config.php');
  require_once(BASE_PATH . '/logic/auth.php');

  if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    $success = tryLogin($_REQUEST['username'], $_REQUEST['password']);
    if ($success) {
      header('Location:index.php');
      die();
    } else {
      $errors['generic'] = "Please enter a valid username or password";
    }
  }

  ?>
  <?php require_once('layout/header.php'); ?>
  <section class="register">
      <div class="container">
          <div class="row">
              <div class="col-sm-12">
                  <h2 class="text-center mb-4">Welcome To Login Page</h2>
                  <form method="POST" action="login.php" class="w-50 m-auto">
                      <div class="mb-3">
                          <input name="username" class=" form-control" placeholder="Username" required />
                      </div>
                      <div class="mb-3">
                          <input name="password" type="password" required class=" form-control"
                              placeholder="Password" />
                      </div>
                      <span class="text text-danger"><?= isset($errors['generic']) ? $errors['generic'] : '' ?></span>

                      <button class="btn btn-success btn-block">Login</button>
                  </form>
              </div>
          </div>
      </div>
  </section>
  <?php require_once('layout/footer.php') ?>