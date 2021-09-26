<?php

require_once(BASE_PATH . '/dal/basic_data.php');

function getPosts($page_size, $page=1, $category_id=null, $tag_id=null, $user_id=null, $q=null) {

    $sql = "SELECT p.*, c.name as category_name, u.name as user_name  FROM posts p
    JOIN categories c ON c.id = p.category_id
    JOIN users u ON u.id = p.user_id
    WHERE 1=1";
    if($category_id != null) {
        $sql .= " AND category_id=$category_id";
    }
    if($tag_id != null) {
        $sql .= " AND p.id IN (SELECT post_id FROM post_tags WHERE tag_id=$tag_id)";
    }
    if($q != null) {
        $sql .= " AND (title LIKE '%$q%' OR content LIKE '%$q%')";
    }
    if($user_id != null) {
        $sql .= " AND user_id = $user_id";
    }

    $offset = ( $page - 1) * $page_size;
    $sql .= " ORDER BY publish_date DESC LIMIT $offset,$page_size";

    $posts = getRows($sql);


    foreach($posts as &$post) {
        $post['comments'] = getPostComment($post['id']);
        $post['tags'] = getPostTags($post['id']);
    }

    return $posts;
}

function getPostComment($post_id) {
    $sql = "SELECT COUNT(0) AS cnt FROM comments WHERE post_id=$post_id";
    $result = getRow($sql);
    if($result === null) return 0;
    return $result['cnt'];
}

function getPostTags($post_id) {
    $sql = "SELECT t.id, t.name FROM post_tags pt
    JOIN tags t ON t.id = pt.tag_id
    WHERE post_id = $post_id";

    return getRows($sql);
}

function getTotalPosts() {
    $sql = 'SELECT COUNT(0) AS total_posts FROM posts';
    $total_posts = getRow($sql)['total_posts'];

    return $total_posts;
}

function getMaxPageSize($page_size) {
    $total_posts = getTotalPosts();

    return ceil($total_posts / $page_size);
}