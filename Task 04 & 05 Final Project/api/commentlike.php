<?php

require_once('../config.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/comments.php');
$id = $_REQUEST['id'];
$comment_date = date('Y-m-d h:i:s', time());

likeComment($id, getUserId(), $comment_date);