<?php
require $_SERVER['DOCUMENT_ROOT'] . "/src/utils/import.util.php";
Import::entities(["category.entity.php", "post.entity.php"]);
Import::repositories(["category.repository.php", "post.repository.php"]);

$cates = null;
$slug = null;
$post = null;
if (isset($_GET["slug"]) && !empty($_GET["slug"])) {
    $slug = htmlspecialchars($_GET["slug"]);
    $cateRepo = new CategoryRepository();
    $postRepo = new PostRepository();
    $cates  = $cateRepo->find();
    $post = $postRepo->findByPostSlug($slug);
    if ($post != null)
        $post = $post["post"];
}

$_METADATA = [
    "title" => "Thêm bài viết",
];
require Import::view_layout_path("content/content.php") ?>

<?php if ($post != null): ?>
    <div class="container mx-auto">
        <?php echo htmlspecialchars_decode($post->context)?>
    </div>
<?php else: ?>
<?php endif; ?>

<?php require Import::view_layout_path("content/end-content.php") ?>