<?php
require "../../../../utils/import.util.php";
Import::entities(["post.entity.php"]);
Import::repositories(["post.repository.php"]);

$_METADATA = [
    "title" => "Thêm bài viết",
    "header-path" => "header/user-header.php",
    "footer-path" => "footer/user-footer.php"
];
require Import::view_layout_path("content/content.php");

$slug = null;
$post = null;
if (isset($_GET["slug"]) && !empty($_GET["slug"])) {
    $slug = htmlspecialchars($_GET["slug"]);
    $postRepo = new PostRepository();
    $post = $postRepo->findByPostSlug($slug);
}
?>

<?php if ($post != null): ?>
    <section class="md:flex md:gap-4 container mx-auto md:px-10 px-4 mt-20">
        <div class="md:flex-1">
            <div data-aos="fade-up">
                <h1 class="text-4xl font-bold"><?php echo $post["post"]->title ?></h1>
                <p class="mb-4 text-gray-600">
                    Ngày đăng: <?php
                                $created_at = new DateTime($post["post"]->created_at);
                                $date = $created_at->format("d-m-Y");
                                echo $date ?>
                </p>
                <hr class="border-gray-900" data-aos="fade-up" />
            </div>
            <div data-aos="fade-up">
                <?php echo htmlspecialchars_decode($post["post"]->context) ?>
            </div>
        </div>
        <div id="posts" class="md:basis-1/5">
            <h1 class="font-semibold text-xl" data-aos="fade-up">Các bài viết liên quan</h1>
            <ul class="space-y-2" id="root-posts"></ul>
        </div>
    </section>
    <script>
        function loadPosts(pageCurrent) {
            $.ajax({
                url: "<?php echo Import::route_path("post.route.php") ?>",
                method: "GET",
                data: {
                    action: "getAllByCategoryIdAndPage",
                    page: pageCurrent,
                    "category_id": <?php echo $post["category"]["id"]; ?>
                },
                success: (response) => {
                    const data = JSON.parse(response)
                    console.log(data);

                    if (data.status) {
                        $("#root-posts").html(data.data.map((item, index) => {
                            const post = item.post;
                            const category = item.category;
                            const date = new Date(post.created_at);
                            const date_show = date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            const decodedContext = $('<div/>').html(post.context).text();
                            return `
                        <div class="max-w-4xl p-2 bg-white rounded-lg hover:shadow border-2 border-gray-200 transition duration-300 ease-in-out space-y-1" data-aos="fade-up">
                            <div class="flex justify-between items-center">
                                <span class="font-light text-gray-600">${date_show}</span>
                            </div>
                            <div class="">
                                <a class="text-xl text-gray-700 font-semibold hover:text-gray-600" href="<?php echo Import::view_page_path("user/posts/details.php") ?>?slug=${post.slug}">
                                    ${post.title}
                                </a>
                            </div>
                            <div class="flex justify-between items-center">
                                <a class="text-blue-600 hover:underline" href="<?php echo Import::view_page_path("user/posts/details.php") ?>?slug=${post.slug}">Đọc</a>
                            </div>
                        </div>
                        `
                        }))
                    }
                },
            })
        }
        let pageCurrent = 1;
        $(() => {
            loadPosts(pageCurrent);
        })
    </script>
<?php else: ?>
<?php endif; ?>

<?php require Import::view_layout_path("content/end-content.php") ?>