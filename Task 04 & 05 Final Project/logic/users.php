<?php
require_once(BASE_PATH . '/dal/basic_dal.php');

function getUsers($page_size, $page = 1, $q = null) {
    $offset = ($page - 1) * $page_size;
    $types = "";
    $vals = [];

    $sql = "SELECT * FROM users WHERE 1=1 AND type = 0";
    $sql = addUserWhereConditions($sql, $q, $types, $vals);
    $sql .= " LIMIT $offset,$page_size";


    $users = getRows($sql, $types, $vals);
    return $users;
}

function getUsersCount($q = null) {
    $sql = "SELECT COUNT(0) AS cnt FROM users WHERE 1=1 AND type = 0";

    $types = '';
    $vals = [];
    $sql = addUserWhereConditions($sql, $q, $types, $vals);
    return getRow($sql, $types, $vals)['cnt'];
}

function addUserWhereConditions($sql, $q = null, &$types, &$vals) {
    if ($q != null) {
        $types .= 'sss';
        array_push($vals, '%' . $q . '%');
        array_push($vals, '%' . $q . '%');
        array_push($vals, '%' . $q . '%');
        $sql .= " AND (name LIKE ? OR username LIKE ? OR email LIKE ? )";
    }

    return $sql;
}

function deleteUser($id) {
    $sql = 'DELETE FROM users WHERE id = ? AND type = 0';
    return execute($sql, 'i', [$id]);
}

function blockUser($id) {
    $sql = "UPDATE users SET active = 0 WHERE id = ?";
    return execute($sql, 'i', [$id]);
}

function unblockUser($id) {
    $sql = 'UPDATE users SET active = 1 WHERE id = ?';
    return execute($sql, 'i', [$id]);
}

function getFollower($following_id, $follower_id) {
    $sql = 'SELECT * FROM follows WHERE following_id = ? AND follower_id = ?';

    return getRow($sql, 'ii', [$following_id, $follower_id]);
}

function followUser($follower_id, $following_id) {
    $follow_date = date('Y-m-d h:i:s', time());
    $sql = "INSERT INTO follows(follower_id, following_id, follow_date) VALUES(? , ?,' $follow_date')";

    return execute($sql, 'ii', [$follower_id, $following_id]);
}

function unfollowUser($follower_id, $following_id) {
    $sql = "DELETE FROM follows WHERE follower_id = ? AND following_id = ?";
    return execute($sql, 'ii', [$follower_id, $following_id]);
}