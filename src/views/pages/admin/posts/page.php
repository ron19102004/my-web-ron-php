<?php
require "../../../../utils/import.util.php";
Import::entities(["category.entity.php"]);
Import::repositories(["category.repository.php"]);

$cateRepo = new CategoryRepository();
$cates = $cateRepo->find();
$_METADATA = [
    "title" => "Bài viết",
];
require Import::view_layout_path("content/content.php") ?>
<!-- component -->
<div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <?php require Import::view_layout_path("header/admin-header.php") ?>
        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-900">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <div class="relative mx-4 lg:mx-0">
                        <h1 class="font-semibold md:text-2xl text-[<?php echo $_COLOR_DEF["red"] ?>]">
                            Quản lý bài viết
                        </h1>
                    </div>
                </div>
                <div>
                    <a href="./create-post.php" class="block text-white bg-blue-700  font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Thêm bài viết
                    </a>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 font-mono">
                <section class="container mx-auto px-6 pt-6">
                    <select id="filter-category-id" class="md:w-fit w-full rounded shadow-lg px-3 py-1 border border-gray-300">
                        <option selected value="0">Chọn bộ lọc thể loại</option>
                        <?php foreach ($cates as $cate): ?>
                            <option value="<?php echo $cate->id ?>"><?php echo $cate->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input id="search-box" type="text" class="md:w-fit w-full rounded shadow-lg px-3 py-1 border border-gray-300" placeholder="Nhập tên tiêu đề">
                    <button id="filter-both" class="w-full md:w-fit rounded shadow-lg px-3 py-1 border border-gray-300 bg-green-200 text-green-700">Lọc cả 2</button>
                </section>
                <!-- component -->
                <section class="container mx-auto p-6 ">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-b border-gray-600">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Tiêu đề</th>
                                        <th class="px-4 py-3">Thể loại</th>
                                        <th class="px-4 py-3">Slug</th>
                                        <th class="px-4 py-3">Trạng thái</th>
                                        <th class="px-4 py-3">Ngày đăng</th>
                                        <th class="px-4 py-3">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white" id="root-table">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 my-4">
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
        </div>
    </div>
</div>
<script>
    function hiddenPostUpdateById(id, value) {
        $.ajax({
            url: "<?php echo Import::route_path("post.route.php") ?>",
            method: "POST",
            data: {
                "action": "hidden-post-update",
                "id": id,
                "value": value
            },
            success: (response) => {
                const data = JSON.parse(response)
                if (data.status) {
                    toast("Cập nhật thành công", "green", 1500)
                    setTimeout(() => {
                        location.reload();
                    }, 500)
                } else {
                    toast("Cập nhật thất bại", "red", 1500)
                }
            },
        })
    }

    function del(id) {
        if (confirm("Bạn có chắc muốn xóa bài viết này?")) {
            $.ajax({
                url: "<?php echo Import::route_path("post.route.php") ?>",
                method: "POST",
                data: {
                    "action": "delete",
                    "id": id
                },
                success: (response) => {
                    const data = JSON.parse(response)
                    if (data.status) {
                        toast("Xóa thành công", "green", 1500)
                        setTimeout(() => {
                            location.reload();
                        }, 500)
                    } else {
                        toast("Xóa thất bại", "red", 1500)
                    }
                },
            })
        }
    }

    function loadTableByCategoryIdAndTitle(cate_id, title, pageCurrent) {
        // getAllByCategoryIdAndPageForAdmin
        $.ajax({
            url: "<?php echo Import::route_path("post.route.php") ?>",
            method: "GET",
            data: {
                action: "searchByTitleAndCategoryAndPageAdmin",
                page: pageCurrent,
                "category_id": cate_id,
                title: title
            },
            success: (response) => {
                console.log(response);
                
                const data = JSON.parse(response)
                
                if (data.status) {
                    render(data)
                }
            },
        })
    }

    function loadTable(pageCurrent) {
        $.ajax({
            url: "<?php echo Import::route_path("post.route.php") ?>",
            method: "GET",
            data: {
                action: "getAllWithPageForAdmin",
                page: pageCurrent
            },
            success: (response) => {
                const data = JSON.parse(response)
                if (data.status) {
                    render(data)
                }
            },
        })
    }

    function render(data) {
        $("#root-table").html(data.data.map(item => {
            const post = item.post;
            const category = item.category;
            const date = new Date(post.created_at);
            const date_show = date.getDay() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear()
            return `
            <tr class="text-gray-700">
                <td class="px-4 py-3 border">
                    ${post.id}
                </td>
                <td class="px-4 py-3 text-ms font-semibold border">
                    ${post.title}
                </td>
                <td class="px-4 py-3 text-ms font-semibold border">${category.name}</td>
                <td class="px-4 py-3 text-ms font-semibold border">
                    <a href="<?php echo Import::view_page_path("user/posts/details.php") ?>?slug=${post.slug}">${post.slug}</a>
                </td>
                <td class="px-4 py-3 text-xs border">
                    <span class="px-2 py-1 font-semibold leading-tight ${post.hidden === 0 ? "text-green-700 bg-green-100":"text-red-700 bg-red-100"} rounded-sm cursor-pointer" onclick="hiddenPostUpdateById('${post.id}','${post.hidden === 0 ? "1":"0"}')">
                        ${post.hidden === 0 ? "Hiển thị":"Đã ẩn"}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm border">${date_show}</td>
                <td class="px-4 py-3 text-sm border">
                    <div class="flex">
                        <a href="./update-post.php?id=${post.id}" class="hover:text-blue-500">Chỉnh sửa</a>
                        <span class="px-4">|</span>
                        <p class="hover:text-red-500" onclick="del('${post.id}')">Xóa</p>
                    </div>
                </td>
            </tr>
            `
        }))
    }
    let pageCurrent = 1;
    $(() => {
        loadTable(pageCurrent);
        $('#prevBtn').click(function() {
            const categoryId = $("#filter-category-id").val();
            const title = $("#search-box").val();
            if (categoryId !== "0" || title.length > 0) {
                if (pageCurrent > 1) {
                    pageCurrent--;
                    loadTableByCategoryIdAndTitle(categoryId, title, pageCurrent);
                    $('#pageCurrent').text(`Trang ${pageCurrent}`);
                }
            } else {
                if (pageCurrent > 1) {
                    pageCurrent--;
                    loadTable(pageCurrent);
                    $('#pageCurrent').text(`Trang ${pageCurrent}`);
                }
            }

        });

        $('#nextBtn').click(function() {
            const categoryId = $("#filter-category-id").val();
            const title = $("#search-box").val();

            if (categoryId !== "0" || title.length > 0) {
                pageCurrent++;
                loadTableByCategoryIdAndTitle(categoryId, title, pageCurrent);
                $('#pageCurrent').text(`Trang ${pageCurrent}`);
            } else {
                pageCurrent++;
                loadTable(pageCurrent);
                $('#pageCurrent').text(`Trang ${pageCurrent}`);
            }
        });
        $("#filter-category-id").change((e) => {
            const categoryId = $("#filter-category-id").val();
            if (categoryId !== "0") {
                pageCurrent = 1;
                loadTableByCategoryIdAndTitle(categoryId, "", pageCurrent);
                $('#pageCurrent').text(`Trang ${pageCurrent}`);
            } else {
                pageCurrent = 1;
                loadTable(pageCurrent);
                $('#pageCurrent').text(`Trang ${pageCurrent}`);
            }
        })
        $("#search-box").change((e) => {
            const value = e.target.value;
            if (value.length > 0) {
                pageCurrent = 1;
                loadTableByCategoryIdAndTitle(0, value, pageCurrent);
                $('#pageCurrent').text(`Trang ${pageCurrent}`);
            }
        })
        $("#filter-both").click(()=>{
            const categoryId = $("#filter-category-id").val();
            const title = $("#search-box").val();
            loadTableByCategoryIdAndTitle(categoryId, title, pageCurrent);
        })
    })
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>