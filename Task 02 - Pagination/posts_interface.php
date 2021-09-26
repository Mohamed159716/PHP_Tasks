<?php 
require_once('./config.php');
require_once('layout/header.php'); 
require_once(BASE_PATH . '/logic/posts.php'); 
require_once(BASE_PATH . '/logic/categories.php');
$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : null;
$tag_id = isset($_REQUEST['tag_id']) ? $_REQUEST['tag_id'] : null;
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : null;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$page_size = 5;

$posts = getPosts($page_size, $page, $category_id, $tag_id, null, $q);


$max_page_size = getMaxPageSize($page_size);
?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Recent Posts</h4>
                        <h2>Our Recent Blog Entries</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Banner Ends Here -->
<section class="blog-posts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sidebar-item search d-flex justify-content-center">
                    <form id="search_form" class="form-group w-50" name="gs" method="GET"
                        action="<?php echo BASE_URL . '/posts.php' ?>">
                        <input type="text" value="<?php echo isset($_REQUEST['q']) ? $_REQUEST['q'] : '' ?>" name="q"
                            class="searchText form-control" placeholder="type to search..." autocomplete="on">
                    </form>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                <div class="all-blog-posts">
                    <div class="row">

                        <?php foreach($posts as $post) { ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="<?php echo $BASE_URL . $post['image'] ?>" alt="">
                                </div>
                                <div class="down-content">
                                    <span><?php echo $post['category_name'] ?></span>
                                    <a href="<?php echo BASE_URL . '/post-details.php?id = ' . $post['id'] ?>">
                                        <h4><?php echo $post['title'] ?></h4>
                                    </a>
                                    <ul class="post-info">
                                        <li><a href="#"><?php echo $post['user_name'] ?></a></li>
                                        <li><a href="#"><?php echo $post['publish_date'] ?></a></li>
                                        <li><a href="#"><?php echo $post['comments'] ?> Comments</a></li>
                                    </ul>
                                    <p><?php echo $post['content'] ?></p>

                                    <?php if($post['tags']) {?>
                                    <div class="post-options">
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="post-tags">
                                                    <li><i class="fa fa-tags"></i></li>
                                                    <?php foreach($post['tags'] as $tag) { ?>
                                                    <li><a
                                                            href="<?php echo BASE_URL . '/posts.php?tag_id=' . $tag['id'] ?>"><?php echo $tag['name'] ?></a>,
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>


                        <?php } ?>

                    </div>
                </div>
                <div class="col-lg-12">
                    <ul class="page-numbers">
                        <?php if($page > 1) { ?>
                        <li><a href="<?php echo BASE_URL . '/posts.php?page=' . $page - 1  ?>"><i
                                    class="fa fa-angle-double-left"></i></a></li>
                        <?php } ?>
                        <?php for($i = 1; $i <= $max_page_size; $i++) { ?>
                        <li class="<?php echo $page == $i ? "active" : "" ?>"><a
                                href="<?php echo BASE_URL . '/posts.php?page=' . $i ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <?php if($page != $max_page_size) { ?>
                        <li><a href="<?php echo BASE_URL . '/posts.php?page=' . $page + 1  ?>"><i
                                    class="fa fa-angle-double-right"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once('layout/footer.php') ?>