<?php
require('../config.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/comments.php');
$comment_id = $_REQUEST['id'];

deleteComment($comment_id, getUserId());