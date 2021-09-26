<?php
require('../config.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/comments.php');
$post_id = $_REQUEST['id'];
$comment = $_REQUEST['comment'];

createComment($post_id, getUserId(), $comment);