<?php
require "../../../../utils/import.util.php";
Import::entities(["post.entity.php"]);
Import::repositories(["post.repository.php"]);


$postRepo = new PostRepository();
$post = $postRepo->findNewLeastRecentPosts();

$_METADATA = [
    "title" => "Trang chủ",
    "header-path" => "header/user-header.php",
    "footer-path" => "footer/user-footer.php"
];
require Import::view_layout_path("content/content.php") ?>
<!-- component -->
<main class="container mx-auto md:px-10 px-4 mt-20">
    <section>
        <section class="bg-white ">
            <div class="grid max-w-screen-xl px-4 pt-10 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
                <?php if ($post != null): ?>
                    <div class="mr-auto place-self-center lg:col-span-7" data-aos="fade-up">
                        <h1
                            class="max-w-2xl mb-4 text-4xl leading-none tracking-tight">
                            <p class="font-bold md:text-5xl xl:text-6xl">Bài viết mới nhất</p>
                            <a href="<?php echo Import::view_page_path("user/posts/details.php") . "?slug=" . $post["post"]->slug ?>" class="font-semibold hover:text-blue-500 md:text-4xl xl:text-5xl">
                                <?php echo $post["post"]->title ?>
                            </a>
                        </h1>
                        <p class="mb-4 text-gray-600">
                            Ngày đăng: <?php
                                        $created_at = new DateTime($post["post"]->created_at);
                                        $date = $created_at->format("d-m-Y");
                                        echo $date ?>
                        </p>
                        <a class="px-4 py-2 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500" href="<?php echo Import::view_page_path("user/posts/details.php") . "?slug=" . $post["post"]->slug ?>">Đọc</a>
                    </div>
                    <div class=" lg:mt-0 lg:col-span-5 lg:flex" data-aos="fade-up">
                        <img src="https://demo.themesberg.com/landwind/images/hero.png" alt="hero image">
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    </section>
    <section class="">
        <h1 class="text-2xl font-bold text-gray-800" data-aos="fade-up">Bài viết</h1>
        <ul class="space-y-4 " id="root-posts"></ul>
        <div class="flex justify-center gap-4 my-4" data-aos="fade-up">
            <button id="prevBtn" class="p-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 flex items-center">
                <i class="fas fa-chevron-left mr-2"></i>
            </button>
            <h1 class="px-1 py-2 bg-gray-50 text-gray-700 rounded flex items-center" id="pageCurrent">Trang 1</h1>
            <button id="nextBtn" class="p-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 flex items-center">
                <i class="fas fa-chevron-right ml-2"></i>
            </button>
        </div>
    </section>
</main>

<script>
   

    function loadPosts(pageCurrent) {
        $.ajax({
            url: "<?php echo Import::route_path("post.route.php") ?>",
            method: "GET",
            data: {
                action: "getAllWithPage",
                page: pageCurrent
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
                        <div class="max-w-4xl p-2 bg-white rounded-lg hover:shadow border border-gray-200 transition duration-300 ease-in-out space-y-1" data-aos="fade-up">
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
        $('#prevBtn').click(function() {
            if (pageCurrent > 1) {
                pageCurrent--;
                loadPosts(pageCurrent);
                $('#pageCurrent').text(`Trang ${pageCurrent}`);
            }
        });

        $('#nextBtn').click(function() {
            pageCurrent++;
            loadPosts(pageCurrent);
            $('#pageCurrent').text(`Trang ${pageCurrent}`);
        });
    })
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>