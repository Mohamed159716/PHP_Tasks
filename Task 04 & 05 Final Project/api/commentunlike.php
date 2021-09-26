<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/comments.php');
$id = $_REQUEST['id'];
unLikeComment($id, getUserId());