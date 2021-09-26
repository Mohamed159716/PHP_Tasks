<?php
require('../config.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/users.php');
$follower_id = $_REQUEST['follower_id'];
$following_id = $_REQUEST['following_id'];

followUser($follower_id, $following_id);