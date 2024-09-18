<?php
require "../../../../utils/import.util.php";
Import::entities(["post.entity.php"]);
Import::repositories(["post.repository.php"]);

$_METADATA = [
    "title" => "Bài viết",
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
            <!-- comment form -->
            <div class="" data-aos="fade-up">
                <h1 class="font-bold text-4xl">Bình luận</h1>
                <div id="show-cmt" class="overflow-y-auto max-h-svh">

                </div>
                <div class="w-full bg-white rounded-lg p-4 my-4 border border-gray-200">
                    <h2 class="text-gray-800 text-xl font-semibold mb-4" id="cmt-box-title">Thêm bình luận</h2>
                    <div class="w-full">
                        <!-- Textarea -->
                        <div class="mb-4">
                            <textarea id="comment-box" class="bg-gray-100 rounded border border-gray-200 leading-normal resize-none w-full h-20 py-2 px-4 font-medium placeholder-gray-600 focus:outline-none focus:bg-white focus:border-indigo-500" name="body" placeholder="Nhập suy nghĩ của bạn..." required></textarea>
                        </div>
                        <!-- Info and Submit Button -->
                        <div class="flex justify-end items-center">
                            <div>
                                <button id="add-cmt-btn" type="submit" class="bg-indigo-600 text-white font-medium py-2 px-6 rounded-lg tracking-wide hover:bg-indigo-500 transition duration-300 ease-in-out">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="posts" class="md:basis-1/5 " data-aos="fade-up">
            <h1 class="font-semibold text-xl">Các bài viết liên quan</h1>
            <ul class="space-y-2 py-2" id="root-posts"></ul>
            <div class="block md:hidden text-center my-4">
                <button id="load-more" class="text-blue-600 underline font-semibold">
                    Xem thêm
                </button>
            </div>
        </div>
    </section>
    <script>
        let pageCurrent = 1;
        let postsLoaded = false;
        let replyCommentId = 0;

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
                    const data = JSON.parse(response);

                    if (data.status) {
                        const postItems = data.data.map((item, index) => {
                            const post = item.post;
                            const date = new Date(post.created_at);
                            const date_show = date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });

                            return `
                            <div class="max-w-4xl p-2 bg-white rounded-lg hover:shadow border-2 border-gray-200 transition duration-300 ease-in-out space-y-1 ${index >= 1 ? ' hidden md:block ' : ''}">
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
                            </div>`;
                        });

                        $("#root-posts").html(postItems);

                        if (!postsLoaded && data.data.length > 1) {
                            $("#load-more").show();
                        } else {
                            $("#load-more").hide();
                        }
                    }
                }
            });
        }

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
        }

        function replyComment(id) {
            replyCommentId = id
            $("#cmt-box-title").text("Trả lời bình luận @" + id)

        }

        function loadComment() {
            $.ajax({
                url: "<?php echo Import::route_path("comment.route.php") ?>",
                method: "GET",
                data: {
                    action: "getAllCommentByPostId",
                    post_id: <?php echo $post["post"]->id; ?>,
                    page: 1
                },
                success: (response) => {
                    const data = JSON.parse(response);
                    if (data.status) {
                        $("#show-cmt").html(data.data.map((item) => {
                            if (item.reply_id == null) {
                                const date = new Date(item.created_at);
                                const date_parent_show = formatDate(date)
                                const cmts_child = data.data.filter(i => i.reply_id === item.id).map(cmt => {
                                    const date_child = new Date(cmt.created_at);
                                    const date_child_show = formatDate(date_child)
                                    return `
                                    <div class="mx-auto bg-white rounded-lg p-4 mt-4 border border-gray-100">
                                        <!-- Tên người dùng -->
                                        <div class="text-lg font-bold text-indigo-600 mb-2">${cmt.fullName}</div>
                                        <!-- Thời gian -->
                                        <p class="text-sm text-gray-500 mb-2">Thời gian: ${date_child_show}</p>
                                        <!-- Nội dung -->
                                        <p class="text-gray-700 leading-relaxed">Nội dung: <span class="font-medium">${cmt.content}</span></p>
                                    </div>
                                    `
                                }).join(" ")
                                return `
                                <div class="mx-auto bg-white rounded-lg p-4 mb-4 border border-gray-200">
                                    <!-- Tên người dùng -->
                                    <div class="text-lg font-bold text-indigo-600 mb-2">${item.fullName}</div>
                                    <!-- Thời gian -->
                                    <p class="text-sm text-gray-500 mb-2">Thời gian: ${date_parent_show}</p>
                                    <!-- Nội dung -->
                                    <p class="text-gray-700 leading-relaxed">Nội dung: <span class="font-medium">${item.content}</span></p>
                                    ${cmts_child}
                                    <div class="flex justify-between items-center mt-4">
                                        <div class="">
                                            <h1>Bình luận @${item.id}</h1>
                                        </div>
                                        <div>
                                            <button onclick="replyComment(${item.id});" type="submit" class=" text-gray-700 border font-medium py-2  px-6 rounded-lg tracking-wide transition duration-300 ease-in-out">Trả lời</button>
                                        </div>
                                    </div>
                                </div>
                                `
                            }
                            return ""
                        }).join(""))
                    }
                }
            })
        }
        $(() => {
            loadPosts(pageCurrent);
            loadComment()
            $("#load-more").on("click", () => {
                postsLoaded = true;
                $("#root-posts").children(".hidden").removeClass("hidden");
                $("#load-more").hide();
            });
            $("#add-cmt-btn").click(() => {
                if ($("#comment-box").val().length === 0) {
                    alert("Vui lòng nhập nội dung bình luận!");
                    return false;
                }                
                $.ajax({
                    url: "<?php echo Import::route_path("comment.route.php") ?>",
                    method: "POST",
                    data: {
                        action: "new",
                        post_id: <?php echo $post["post"]->id; ?>,
                        content: $("#comment-box").val(),
                        user_id: <?php echo Session::get("user_id"); ?>,
                        reply_to: replyCommentId
                    },
                    success: (response) => {                        
                        const data = JSON.parse(response);
                        if (data.status) {
                            $("#comment-box").val("");
                            toast(data.message, "green", 1500);
                            replyCommentId = 0;
                            $("#cmt-box-title").text("Thêm bình luận")
                            loadComment()
                        } else {
                            toast(data.message, "red", 1500);
                        }
                    }
                })
            })
        });
    </script>
<?php else: ?>
    <div class="flex flex-col items-center justify-center min-h-screen ">
        <!-- Thông báo lỗi -->
        <p class="text-2xl font-semibold text-gray-800 mb-4">Bài viết không tồn tại.</p>
        <!-- Nút quay lại -->
        <a href="<?php echo Env::get("root-path") ?>/" class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-500 transition duration-300 ease-in-out">
            Quay lại trang chủ
        </a>
    </div>
<?php endif; ?>

<?php require Import::view_layout_path("content/end-content.php") ?>