<?php
require_once BASE_PATH . '/dal/basic_dal.php';

function isPostWithTag($post_id, $tag_id) {
    $sql = "SELECT * FROM post_tags WHERE post_id = $post_id AND tag_id = $tag_id";
    if (getRow($sql)) {
        return true;
    }
    return false;
}

function deletePostTags($post_id, $tag_id) {
    $sql = "DELETE FROM post_tags WHERE post_id = $post_id AND tag_id = $tag_id";
    return deleteData($sql);
}