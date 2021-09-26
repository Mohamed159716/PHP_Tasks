<?php
require_once(BASE_PATH . '/dal/basic_dal.php');
function getPostComments($postId, $like_by_user_id = null) {
    $sql = "SELECT c.*, u.username FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.post_id = $postId
    ";
    $comments =  getRows($sql);

    foreach ($comments as &$comment) {
        $comment['comment_likes_count'] = getCommentLikesCount($comment['id']);
        if ($like_by_user_id) {
            $comment['like_comment_by_me'] = getIfLikedCommentByMe($comment['id'], $like_by_user_id);
        } else {
            $comment['like_comment_by_me'] = false;
        }
    }

    return $comments;
}

function getCommentLikesCount($comment_id) {
    $sql = "SELECT COUNT(0) as cnt FROM comment_likes WHERE comment_id=$comment_id";
    $result = getRow($sql);
    if ($result == null) return 0;
    return $result['cnt'];
}

function getIfLikedCommentByMe($comment_id, $user_id) {
    $sql = "SELECT id FROM comment_likes WHERE comment_id = ? AND user_id = ?";
    return getRow($sql, 'ii', [$comment_id, $user_id]) != null;
}

function likeComment($id, $user_id, $comment_date) {
    $sql = "INSERT INTO comment_likes(comment_id, user_id, like_date) VALUES(?, ?, '$comment_date');";

    execute($sql, 'ii', [$id, $user_id]);
}

function unLikeComment($id, $user_id) {
    $sql = "DELETE FROM comment_likes WHERE comment_id = ? AND user_id = ?";
    execute($sql, 'ii', [$id, $user_id]);
}
function deleteComment($comment_id, $user_id) {

    $status = checkAuthority($user_id);

    print_r($status);


    if ($status) {
        $sql = 'DELETE FROM comments WHERE id = ?';
        execute($sql, 'i', [$comment_id]);
    }
    return false;
}

function createComment($post_id, $user_id, $comment) {
    $comment_date = date('Y-m-d h:i:s', time());
    $sql = "INSERT INTO comments(comment, post_id, user_id, comment_date) VALUES(? , ?, ?, '$comment_date')";

    execute($sql, 'sii', [$comment, $post_id, $user_id]);
}