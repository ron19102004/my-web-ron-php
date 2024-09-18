<?php
require "../../../../utils/import.util.php";
if (!AuthMiddleware::hasRoles([UserRole::ADMIN])) {
    header("Location: " . Env::get("root-path") . "/src/views/pages/auth/login/page.php");
    exit();
}
Import::entities(["category.entity.php", "post.entity.php"]);
Import::repositories(["category.repository.php", "post.repository.php"]);

$cates = null;
$post_id = null;
$post = null;
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $post_id = htmlspecialchars($_GET["id"]);
    $cateRepo = new CategoryRepository();
    $postRepo = new PostRepository();
    $cates  = $cateRepo->find();
    $post = $postRepo->findByPostId($post_id);
    if ($post != null)
        $post = $post["post"];
}

$_METADATA = [
    "title" => "Cập nhật bài viết",
];
require Import::view_layout_path("content/content.php") ?>
<?php if ($post != null): ?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>

    <div class="mx-auto p-8">
        <h1 class="text-5xl font-bold mb-8 text-gray-900 text-center">Cập nhật bài viết</h1>
        <form>
            <div class="mb-6">
                <label for="title" class="block text-xl text-gray-800 font-semibold mb-2">Thể loại bài viết:</label>
                <select name="cate" id="cate" class="w-full px-4 py-4 text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    <option value="0" selected>Chọn danh mục</option>
                    <?php foreach ($cates as $cate) : ?>
                        <option value="<?php echo $cate->id ?>">
                            <?php echo $cate->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-6">
                <label for="title" class="block text-xl text-gray-800 font-semibold mb-2">Tiêu đề bài viết:</label>
                <input value="<?php echo $post->title ?>" type="text" id="title" name="title" required
                    class="w-full px-4 py-4 text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
            </div>

            <div class="mb-8">
                <label for="content" class="block text-xl text-gray-800 font-semibold mb-2">Nội dung bài viết:</label>
                <textarea id="content" name="content" rows="12"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 resize-none"></textarea>
            </div>

            <div class="text-right">
                <button id="btn-submit" type="submit"
                    class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg transition duration-300">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 600, // Chiều cao của editor
                toolbar: [
                    // [groupName, [list of buttons]]
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $('#content').summernote('code', `<?php echo htmlspecialchars_decode($post->context) ?>`);
            $("#btn-submit").click((e) => {
                e.preventDefault()
                const data = {
                    "title": $("#title").val(),
                    "context": $("#content").val(),
                    "category_id": $("#cate").val(),
                    "id": "<?php echo $post_id ?>",
                    "action": "update"
                }
                if (data.categoryId === "0") {
                    alert("Vui lòng chọn thể loại")
                    return
                }
                if (data.title.length === 0) {
                    alert("Vui lòng nhập tiêu đề")
                    return
                }
                $.ajax({
                    url: "<?php echo Import::route_path("post.route.php") ?>",
                    method: "POST",
                    data: data,
                    success: (response) => {
                        console.log(response);

                        const data = JSON.parse(response)
                        if (data.status) {
                            toast("Cập nhật thành công", "green", 1500)
                            setTimeout(() => {
                                location.href = "<?php echo Import::view_page_path("admin/posts/page.php") ?>"
                            }, 1500)
                        } else {
                            toast("Cập nhật thất bại", "red", 1500)
                        }
                    },
                })
            })
        });
    </script>
<?php else: ?>
    <div class="flex flex-col justify-center items-center min-h-screen">
        <div class="bg-white p-10 rounded-lg md:shadow-lg text-center max-w-md">
            <img src="https://via.placeholder.com/150" alt="404 Not Found" class="mx-auto mb-6 w-32 h-32 object-cover">

            <h1 class="text-5xl font-extrabold text-red-500 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Không tìm thấy dữ liệu</h2>

            <p class="text-gray-600 mb-6">
                Trang bạn đang tìm kiếm không tồn tại hoặc dữ liệu bạn yêu cầu không có sẵn.
            </p>

            <a href="/"
                class="inline-block px-8 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-300">
                Quay lại trang chủ
            </a>
        </div>
    </div>
<?php endif; ?>


<?php require Import::view_layout_path("content/end-content.php") ?>