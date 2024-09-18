<?php
require $_SERVER['DOCUMENT_ROOT'] . "/ron/src/utils/import.util.php";

$slug = null;
if (isset($_GET["slug"]) && !empty($_GET["slug"])) {
    $slug  = htmlspecialchars($_GET["slug"]);
}

$_METADATA = [
    "title" => "Bài viết theo thể loại",
    "header-path" => "header/user-header.php"
];
require Import::view_layout_path("content/content.php") ?>

<main class="container mx-auto md:px-10 px-4 mt-20">
    <section class="">
        <h1 class="text-2xl font-bold text-gray-800" data-aos="fade-up">Bài viết</h1>
        <ul class="space-y-4 " id="root-posts"></ul>
        <div class="flex justify-between md:justify-start gap-4 my-4" data-aos="fade-up">
            <button id="prevBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 flex items-center">
                <i class="fas fa-chevron-left mr-2"></i> Previous
            </button>
            <h1 class="px-4 py-2 bg-gray-50 text-gray-700 rounded flex items-center">Trang 1</h1>
            <button id="nextBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 flex items-center">
                Next <i class="fas fa-chevron-right ml-2"></i>
            </button>
        </div>
    </section>
</main>
<script>
    function copy(content) {
        navigator.clipboard.writeText(content).then(() => {
            alert('Đường dẫn đã được sao chép vào bộ nhớ tạm!');
        }).catch(err => {
            console.error('Không thể sao chép: ', err);
        });
    }

    function loadPosts(pageCurrent) {
        $.ajax({
            url: "<?php echo Import::route_path("post.route.php") ?>",
            method: "GET",
            data: {
                action: "getAllByCategorySlugAndPage",
                page: pageCurrent,
                slug: '<?php echo $slug?>'
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
                        <div class="max-w-4xl p-6 bg-white rounded-lg hover:shadow border border-gray-200 transition duration-300 ease-in-out space-y-1" data-aos="fade-up">
                            <div class="flex justify-between items-center">
                                <span class="font-light text-gray-600">${date_show}</span>
                                <button onclick="copy('<?php echo Import::view_page_path("user/posts/details.php") ?>?slug=${post.slug}');" class="px-2 py-1 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500">Copy</button>
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
            }
        });

        $('#nextBtn').click(function() {
            pageCurrent++;
            loadPosts(pageCurrent);
        });
    })
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>