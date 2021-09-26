<div class="blog-post">
    <div class="blog-thumb">
        <img src="<?= BASE_URL . '/post_images/' . $post['image'] ?>" alt="">
    </div>
    <div class="down-content">
        <span><?= $post['category_name'] ?></span>

        <h4><?= $post['title'] ?></h4>
        <?php if ($post['user_id'] != getUserId()) { ?>
        <?php if (getFollower($post['user_id'], getUserId())) { ?>
        <button onclick="unFollowUser(<?php echo $post['user_id'] . ',' .  getUserId() ?>)"
            id="<?php echo 'unfollow_user_' . $post['id'] . '_' . $post['user_id'] . '_' . getUserId(); ?>"
            class="btn btn-info bg-transparent text-info">UnFollow <?php echo $post['user_name'] ?></button>
        <?php } else { ?>
        <button onclick="followUser(<?php echo $post['user_id'] . ',' .  getUserId() ?>)" class="btn btn-info">Follow
            <?php echo $post['user_name'] ?></button>
        <?php } ?>
        <?php } ?>

        <ul class="post-info">
            <li><a href="#"><?= $post['user_name'] ?></a></li>
            <li><a href="#"><?= $post['publish_date'] ?></a></li>
            <li><a href="#"><?= count($post['comments']) ?> Comments</a></li>
        </ul>
        <p><?= $post['content'] ?></p>
        <?php
        if ($post['tags']) {
        ?>
        <div class="post-options">
            <div class="row">
                <div class="col-6">
                    <ul class="post-tags">
                        <li><i class="fa fa-tags"></i></li>
                        <?php
                            foreach ($post['tags'] as $tag) {
                            ?>
                        <li><a href="<?= BASE_URL . "/posts.php?tag_id={$tag['id']}" ?>"><?= $tag['name'] ?></a></li>
                        <?php
                            }
                            ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="container">



            <div class="row">
                <div class="col-sm-12 text-primary">
                    <i class=" fa fa-thumbs-up fa-sm"></i> <span class="text-primary"
                        id="likes_count_<?= $post['id'] ?>">
                        <?= $post['likes_count']; ?></span>
                </div>
            </div>
            <hr>
            <div class="row mx-auto">
                <div class="col-sm-6 d-flex justify-content-center">
                    <?php if (checkLogin()) { ?>

                    <button id="likes_btn_<?= $post['id'] ?>" class="btn btn-secondary" type="button"
                        onclick="likePost(<?= $post['id']; ?>)"
                        style="display:<?= !$post['liked_by_me'] ? "block" : "none" ?>"><i
                            class="fa fa-thumbs-up fa-1x"></i>
                        Like</button>
                    <button id="unlikes_btn_<?= $post['id'] ?>" class="btn btn-secondary" type="button"
                        onclick="unLikePost(<?= $post['id']; ?>)"
                        style="display:<?= !$post['liked_by_me'] ? "none" : "block" ?>"><i
                            class="fa fa-thumbs-down fa-1x"></i> UnLike
                    </button>

                    <?php } else { ?>
                    <a href="<?php echo BASE_URL . '/login.php'; ?>" class="btn btn-secondary"><i
                            class="fa fa-thumbs-up fa-1x"></i> Like</a>
                    <?php } ?>

                </div>

                <div class="col-sm-6 d-flex justify-content-center">
                    <button class="btn btn-secondary" onclick="<?php echo 'shoComments(' . $post['id'] . ')' ?>"><i
                            class="fa fa-comment"></i> Comment</button>
                </div>
            </div>
            <hr>
            <div class="col-sm-12" id="comments_input_<?php echo $post['id'] ?>">
                <?php if (checkLogin()) { ?>
                <div id="comment_field_<?php echo $post['id'] ?>" contenteditable="true"
                    class="border border-secondary p-2" data-placeholder="Type a comment..."
                    onkeyup="<?php echo 'commentCreation(event,' . $post['id'] . ')' ?>"></div>
                <?php } else { ?>
                <input type="text" class="border border-secondary p-2 w-100" placeholder="Type a comment..."
                    onkeypress="<?php echo 'redirectToLogin(event)'; ?>" />
                <?php } ?>
            </div>
        </div>
        <hr id="comment_hr_<?php echo $post['id'] ?>">
        <div class="col-sm-12" id="comments_section_<?php echo $post['id'] ?>">
            <?php foreach ($post['comments'] as $comment) { ?>
            <div class="mb-4 comment_parent">
                <div class="comment_details shadow-sm p-3 mb-1 bg-white rounded">
                    <h4><?php echo $comment['username']; ?></h4>
                    <p class="border-0 py-0 pl-1 my-0"><?php echo $comment['comment'] ?></p>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php if (checkLogin()) { ?>
                        <button id="comment_like_<?php echo $comment['id']; ?>"
                            class="btn btn-primary bg-transparent text-primary border-0" type="button"
                            onclick="likeComment(<?php echo $comment['id']; ?>)"
                            style="display: <?php echo $comment['like_comment_by_me'] != 1 ? 'block' : 'none'; ?>">
                            <i class="fa fa-thumbs-o-up fa-sm"></i> <span
                                class="text-primary"><?php echo $comment['comment_likes_count']; ?></span>
                        </button>

                        <button id="comment_unlike_<?php echo $comment['id']; ?>"
                            class="btn btn-primary bg-transparent text-primary border-0" type="button"
                            onclick="unLikeComment(<?php echo $comment['id']; ?>)"
                            style="display:<?php echo $comment['like_comment_by_me'] == 1 ? 'block' : 'none' ?>">
                            <i class="fa fa-thumbs-o-down fa-sm"></i> <span
                                class="text-primary"><?php echo $comment['comment_likes_count']; ?></span>
                        </button>
                        <?php } else { ?>

                        <a class="btn btn-primary bg-transparent text-primary border-0"
                            href="<?php echo BASE_URL . '/login.php'; ?>">
                            <i class="fa fa-thumbs-o-up fa-sm"></i> <span
                                class="text-primary"><?php echo $comment['comment_likes_count']; ?></span>
                        </a>

                        <?php } ?>
                    </div>
                    <div class='col-sm-6 d-flex justify-content-end'>

                        <?php if (checkAuthority($comment['user_id']) || $post['user_id'] == getUserId()) { ?>
                        <button id="comment_trash_<?php echo $comment['id']; ?>"
                            class="btn btn-danger comment_like bg-transparent border-0 text-danger"
                            onclick="deleteComment(<?php echo $comment['id']; ?>)">
                            <i class="fa fa-trash"></i>
                        </button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php } ?>

        </div>
    </div>
</div>