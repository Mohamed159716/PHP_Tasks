<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/users.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/categories.php');

$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : null;
$tag_id = isset($_REQUEST['tag_id']) ? $_REQUEST['tag_id'] : null;
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : null;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$page_size = 6;
$order_field = isset($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'id';
$order_by = isset($_REQUEST['order_by']) ? $_REQUEST['order_by'] : 'asc';
$posts = getPosts($page_size, $page, $category_id, $tag_id, null, $q, $order_field, $order_by, getUserId());
// $posts_count  = getPostsCount($category_id, $tag_id, null, $q);
// $page_count = ceil($posts_count / $page_size);


function getUrl($p, $category_id, $tag_id, $q) {
    $url = BASE_URL . "/admin/users.php?page=$p";
    if ($category_id != null) $url .= "&category_id=$category_id";
    if ($tag_id != null) $url .= "&tag_id=$tag_id";
    if ($q != null) $url .= "&q=$q";
    return $url;
}
function getSortingUrl($field, $oldOrderField, $oldOrderBy, $q) {
    if ($field == $oldOrderField && $oldOrderBy == 'asc') {
        return "users.php?page=1&q=$q&order_field=$field&order_by=desc";
    }
    if ($field == $oldOrderField && $oldOrderBy == 'desc') {
        return "users.php?page=1&q=$q";
    }
    return  "users.php?page=1&q=$q&order_field=$field&order_by=asc";
}
function getSortFlag($field, $oldOrderField, $oldOrderBy) {

    if ($field == $oldOrderField && $oldOrderBy == 'asc') {
        return "<i class='fa fa-sort-up'></i>";
    }
    if ($field == $oldOrderField && $oldOrderBy == 'desc') {
        return "<i class='fa fa-sort-down'></i>";
    }
    return  "";
}



$users_count  = getUsersCount($q);
$page_count = ceil($users_count / $page_size);

$users = getUsers($page_size, $page, $q);

// echo "<pre>";
// print_r($users);
// echo "</pre>";
// echo $users_count;
// die();

?>
<?php require_once(BASE_PATH . '/layout/header.php'); ?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Admin Dashboard</h4>
                        <h2>All Users</h2>
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
                <div class="sidebar-item search">
                    <form id="search_form" name="gs" method="GET" action="<?= BASE_URL . '/admin/users.php' ?>">
                        <input type="text" value="<?= isset($_REQUEST['q']) ? $_REQUEST['q'] : '' ?>" name="q"
                            class="searchText form-control" placeholder="type to search..." autocomplete="on">
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="all-blog-posts">
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><a href="<?= getSortingUrl('title', $order_field, $order_by, $q) ?>">Name
                                            <?= getSortFlag('title', $order_field, $order_by) ?></a></th>
                                    <th><a href="<?= getSortingUrl('category_name', $order_field, $order_by, $q) ?>">UserName
                                            <?= getSortFlag('category_name', $order_field, $order_by) ?></a></th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = ($page - 1) * $page_size + 1;
                                foreach ($users as $user) {
                                    $blockUser = $user['active'] == 1 ? 'Block' : 'Unblock';
                                    $blockUrl = $user['active'] == 1 ? 'blockuser.php?id=' : 'unblockuser.php?id=';
                                    echo "<tr>
                                        <td>$i</td>
                                        <td>" . htmlspecialchars($user['name']) . "</td>
                                        <td>{$user['username']}</td>
                                        <td>{$user['email']}</td>
                                        <td>{$user['phone']}</td>
                                        <td>
                                        <a href='{$blockUrl}{$user['id']}' class='btn btn-warning'>{$blockUser}</a>
                                        <a onclick='return confirm(\"Are you sure ?\")' href='deleteuser.php?id={$user['id']}' class='btn btn-danger'>Delete</a>
                                        </td>
                                    </tr>";

                                    $i++;
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <ul class="page-numbers">
                        <?php
                        $prevUrl = getUrl($page - 1, $category_id, $tag_id, $q);
                        $nxtUrl = getUrl($page + 1, $category_id, $tag_id, $q);

                        if ($page > 1) echo "<li><a href='{$prevUrl}'><i class='fa fa-angle-double-left'></i></a></li>";

                        for ($i = 1; $i <= $page_count; $i++) {
                            $url = getUrl($i, $category_id, $tag_id, $q);
                            echo "<li class=" . ($i == $page ? "active" : "") . "><a href='{$url}'>{$i}</a></li>";
                        }

                        if ($page < $page_count) echo "<li><a href='{$nxtUrl}'><i class='fa fa-angle-double-right'></i></a></li>";
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once(BASE_PATH . '/layout/footer.php') ?>