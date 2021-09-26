<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/categories.php');
require_once(BASE_PATH . '/logic/tags.php');

$post_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

if ($post_id == null) {
    header('Location: index.php');
    die();
}


function getUserId() {
    if (session_status() != PHP_SESSION_ACTIVE) session_start();
    if (isset($_SESSION['user'])) return $_SESSION['user']['id'];
    return 0;
}

$post =  getPosts(1, null, null, null, null, null, null, null, $post_id);

$tags = getTags();

$categories = getCategories();
if (isset($_REQUEST['title'])) {
    $errors = ValidatePostCreate($_REQUEST);

    $image = "";

    if ($_FILES['image']['name'] == "") {
        $image = $post[0]['image'];
    } else {
        $image = getUploadedImage($_FILES);
    }


    if (count($errors) == 0) {
        UpdatePost($_REQUEST, getUserId(), $image, $post_id, $oldTags = $post[0]['tags']);
        header('Location: index.php');
        die();
    }
    $generic_error = "Error while adding the post";
}



require_once(BASE_PATH . '/layout/header.php');

?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Update Post</h4>
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

                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                <div class="all-blog-posts">
                    <div class="row">

                        <div class="col-sm-12">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="text" class="form-control" name="title"
                                    value="<?php echo $post[0]['title']; ?>" placeholder="title">
                                <?php echo isset($errors['title']) ? "<span class='text-danger'>{$errors['title']}</span>" : "" ?>
                                <textarea type="text" class="form-control my-2" name="content"
                                    placeholder="content"><?php echo $post[0]['content']; ?></textarea>
                                <?php echo isset($errors['title']) ? "<span class='text-danger'>{$errors['title']}</span>" : "" ?>
                                <img class="d-inline-block my-3"
                                    src="<?php echo BASE_URL . '/post_images/' . $post[0]['image']; ?>" width=100
                                    height=100 /></br>
                                <label>Upload Image <input type="file" name="image" /></label><br />
                                <?php echo isset($errors['title']) ? "<span class='text-danger'>{$errors['title']}</span>" : "" ?>
                                <label>Publish Date <input type="date" name="publish_date"
                                        value="<?php echo explode(" ", $post[0]['publish_date'])[0]; ?>"></label><br />
                                <?php echo isset($errors['title']) ? "<span class='text-danger'>{$errors['title']}</span>" : "" ?>
                                <select name="category_id" class="form-control">
                                    <option value="" disabled>Select Category</option>
                                    <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo  $category['id']; ?>"
                                        <?php echo $post[0]['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                        <?php echo $category['name'] ?>
                                    </option>
                                    <?php } ?>
                                </select>

                                </select>
                                <?php echo isset($errors['title']) ? "<span class='text-danger'>{$errors['title']}</span>" : "" ?>
                                <select name="tags[]" multiple class="form-control my-2">
                                    <option value="" disabled>Select Category</option>
                                    <?php
                                    foreach ($tags as $tag) {
                                        $selected = "";
                                        foreach ($post[0]['tags'] as $userTag) {
                                            if ($userTag['id'] == $tag['id']) {
                                                $selected = "selected";
                                            }
                                        }
                                        echo "<option value='{$tag['id']}' {$selected}>{$tag['name']}</option>";
                                    }

                                    ?>
                                </select>
                                <?php echo isset($errors['title']) ? "<span class='text-danger'>{$errors['title']}</span>" : "" ?>
                                <button type="submit" class="btn btn-success my-2">Update Post</button>
                                <a href="index.php" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php require_once(BASE_PATH . '/layout/footer.php') ?>