<?php

require_once BASE_PATH . '/dal/basic_dal.php';
require_once('post_tag.php');


function getPosts(
    $page_size,
    $page = 1,
    $category_id = null,
    $tag_id = null,
    $user_id = null,
    $q = null,
    $order_field = "publish_date",
    $order_by = "desc",
    $post_id = null
) {

    if ($page == null) $page = 1;
    if ($order_field == null) $order_field = "publish_date";
    if ($order_by == null) $order_by = "desc";

    if ($post_id != null) {
        if (!checkPostFound($post_id)) {
            header('Location: index.php');
            die();
        }
    }


    $sql = "SELECT p.*, c.name as category_name, u.name as user_name  FROM posts p
    JOIN categories c ON c.id = p.category_id
    JOIN users u ON u.id = p.user_id
    WHERE 1=1";
    if ($category_id != null) {
        $sql .= " AND category_id=$category_id";
    }
    if ($tag_id != null) {
        $sql .= " AND p.id IN (SELECT post_id FROM post_tags WHERE tag_id=$tag_id)";
    }
    if ($q != null) {
        $sql .= " AND (title LIKE '%$q%' OR content LIKE '%$q%')";
    }
    if ($user_id != null) {
        $sql .= " AND user_id = $user_id";
    }
    if ($post_id != null) {
        $sql .= " AND p.id = $post_id";
    }

    $offset = ($page - 1) * $page_size;
    $sql .= " ORDER BY $order_field $order_by LIMIT $offset,$page_size";

    $posts = getRows($sql);

    foreach ($posts as &$post) {
        $post['comments'] = getPostComment($post['id']);
        $post['tags'] = getPostTags($post['id']);
    }

    return $posts;
}

function getPostComment($post_id) {
    $sql = "SELECT COUNT(0) AS cnt FROM comments WHERE post_id=$post_id";
    $result = getRow($sql);
    if ($result === null) {
        return 0;
    }

    return $result['cnt'];
}

function checkPostFound($post_id) {
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    return getRow($sql);
}


function getPostTags($post_id) {
    $sql = "SELECT t.id, t.name FROM post_tags pt
    JOIN tags t ON t.id = pt.tag_id
    WHERE post_id = $post_id";

    return getRows($sql);
}

function getTotalPosts($user_id = null) {
    $sql = 'SELECT COUNT(0) AS total_posts FROM posts ';
    $sql .= ($user_id != null) ? "WHERE user_id=$user_id" : "";
    $total_posts = getRow($sql)['total_posts'];


    return $total_posts;
}

function getMaxPageSize($page_size) {
    $total_posts = getTotalPosts();

    return ceil($total_posts / $page_size);
}

function getMyPosts($page_size, $page, $user_id, $q, $order_field, $order_by) {
    return [
        'data' => getPosts($page_size, $page, null, null, $user_id, $q, $order_field, $order_by), 'count' => getTotalPosts($user_id),
    ];
}

function ValidatePostCreate($request) {
    $errors = [];

    return $errors;
}

function addNewPost($request, $user_id, $image) {
    $sql = "INSERT INTO posts(id, title, content, image, publish_date, category_id, user_id) VALUES(NULL, ?, ?, ?, ?, ?, ?)";
    $post_id = addData($sql, 'ssssii', [
        $request['title'],
        $request['content'],
        $image,
        $request['publish_date'],
        $request['category_id'],
        $user_id
    ]);
    if ($post_id) {
        if (isset($request['tags'])) {
            foreach ($request['tags'] as $tag_id) {
                addData("INSERT INTO post_tags(post_id, tag_id) VALUES(?, ?);", "ii", [$post_id, $tag_id]);
            }
        }
        return true;
    }
    return false;
}

function updatePost($request, $user_id, $image, $post_id, $old_tags = null) {


    $sql = "UPDATE posts set title = ?, content = ?, image=?, publish_date=?, category_id=?, user_id=? WHERE id = $post_id";
    editData($sql, 'ssssii', [
        $request['title'],
        $request['content'],
        $image,
        $request['publish_date'],
        $request['category_id'],
        $user_id
    ]);




    // Remove the old Tags.
    if ($old_tags != null) {
        foreach ($old_tags as $tag) {
            if (isPostWithTag($post_id, $tag['id'])) {
                deletePostTags($post_id, $tag['id']);
            }
        }
    }


    if (isset($request['tags'])) {
        foreach ($request['tags'] as $tag_id) {
            editData("INSERT INTO post_tags (post_id, tag_id) VALUES(?, ?);", "ii", [$post_id, $tag_id]);
        }
    }
    return true;
}

function getUploadedImage($files) {
    move_uploaded_file($files['image']['tmp_name'], BASE_PATH . '/post_images/' . $files['image']['name']);
    return $files['image']['name'];
}