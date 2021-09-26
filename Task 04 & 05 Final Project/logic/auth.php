<?php
require_once(BASE_PATH . '/dal/basic_dal.php');
require_once(BASE_PATH . '/logic/auth.php');
function tryLogin($username, $password) {
    $user = getUser($username, $password);
    if ($user != null) {
        addUserToSession($user);
    }
    return ($user != null);
}
function tryRegister($name, $username, $email, $password, $phone) {
    $sql = "SELECT * FROM users WHERE email = '$email'";

    if (getRow($sql) == null) {
        if (registerUser($name, $username, $email, $password, $phone)) {
            tryLogin($username, $password);
        }
        return false;
    }
    return false;
}
function registerUser($name, $username, $email, $password, $phone) {
    $sql = "INSERT INTO users(name, username, email, password, phone) VALUES(?, ?, ?, md5(?), ?)";
    return execute($sql, 'sssss', [$name, $username, $email, $password, $phone]);
}

function getUser($username, $password) {
    $sql = "SELECT * FROM users WHERE username=? and password = md5(?) AND active = 1 limit 1;";
    return getRow($sql, 'ss', [$username, $password]);
}

function checkLogin() {
    if (isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function addUserToSession($user) {
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION['user'] = $user;
}
function logOut() {
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_destroy();
    header('Location:' . BASE_URL . '/index.php');
    die();
}
function getUserId() {
    if (session_status() != PHP_SESSION_ACTIVE) session_start();
    if (isset($_SESSION['user'])) return $_SESSION['user']['id'];
    return 0;
}

function checkAuthority($user_id) {
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['user']))
        return false;

    return $_SESSION['user']['type'] == 1 || $_SESSION['user']['id'] == $user_id;
}