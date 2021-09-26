<?php

function getConnection() {
    $conn =  mysqli_connect('localhost', 'root', '', 'blog');
    mysqli_query($conn, "SET CHARACTER SET utf-8");
    return $conn;
}

function getRows($sql) {
    $results = [];
    $conn = getConnection();
    if ($conn) {
        $query = mysqli_query($conn, $sql);
        mysqli_close($conn);
        while (($row = mysqli_fetch_assoc($query)) != null) {
            array_push($results, $row);
        }
    }
    return $results;
}

function getRow($sql) {
    $results = getRows($sql);
    if (count($results) > 0)
        return $results[0];
    return null;
}

function executeQuery($sql, $types, $vals) {
    $conn = getConnection();
    if ($conn) {
        if ($types && $vals) {
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, $types, ...$vals);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            mysqli_query($conn, $sql);
        }
    }

    $last_id = mysqli_insert_id(($conn));
    mysqli_close($conn);
    return $last_id;
}

function addData($sql, $types, $vals) {
    $last_id = executeQuery($sql, $types, $vals);
    return $last_id;
}

function editData($sql, $types, $vals) {
    executeQuery($sql, $types, $vals);
    return true;
}

function deleteData($sql) {
    $conn = getConnection();
    if ($conn) {
        mysqli_query($conn, $sql);
    }

    return true;
}