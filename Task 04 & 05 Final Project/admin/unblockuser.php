<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/users.php');
if (!isset($_REQUEST['id'])) {
    header('Location:index.php');
    die();
}
$id = $_REQUEST['id'];

unblockUser($id);
header('Location: ' . BASE_URL . '/admin/users.php');
die();