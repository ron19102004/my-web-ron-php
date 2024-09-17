<?php
require $_SERVER['DOCUMENT_ROOT'] . "/src/utils/import.util.php";
Import::entities(["category.entity.php"]);
Import::repositories(["category.repository.php"]);

$cateRepo = new CategoryRepository();
$cates  = $cateRepo->find();

$_METADATA = [
    "title" => "Thể loại",
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
                            Quản lý thể loại
                        </h1>
                    </div>
                </div>
                <div>
                    <!-- Modal toggle -->
                    <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700  font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Thêm thể loại
                    </button>

                    <!-- Main modal -->
                    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <?php require "./create-category.php" ?>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Tên</th>
                                        <th class="px-4 py-3">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php foreach ($cates as $cate): ?>
                                        <tr class="text-gray-700">
                                            <td class="px-4 py-3 border">
                                                <?php echo $cate->id ?>
                                            </td>
                                            <td class="px-4 py-3 text-ms font-semibold border">
                                                <?php echo $cate->name ?>
                                            </td>
                                            <td class="px-4 py-3 text-xs border">
                                                <button data-modal-target="default-modal-<?php echo $cate->id ?>" data-modal-toggle="default-modal-<?php echo $cate->id ?>" class="text-blue-400  underline pl-6" type="button">
                                                    Sửa
                                                </button>
                                                <!-- Main modal -->
                                                <div id="default-modal-<?php echo $cate->id ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                        <div class="flex items-center justify-center p-12">
                                                            <div class="mx-auto w-full max-w-[550px] bg-white p-4 md:p-6 rounded shadow-lg">
                                                                <div>
                                                                    <div class="mb-5">
                                                                        <label
                                                                            for="name"
                                                                            class="mb-3 block text-base font-medium text-[#07074D]">
                                                                            Tên thể loại
                                                                        </label>
                                                                        <input
                                                                            value="<?php echo $cate->name ?>"
                                                                            type="text"
                                                                            id="name-<?php echo $cate->id ?>"
                                                                            placeholder="Full Name"
                                                                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                                                    </div>
                                                                    <div class="float-right">
                                                                        <button
                                                                            onclick="update('<?php echo $cate->id ?>');"
                                                                            class="hover:shadow-form rounded-md bg-green-700 py-3 px-8 text-base font-semibold text-white outline-none">
                                                                            Cập nhật
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button onclick="del('<?php echo $cate->id ?>');" class="text-blue-400 underline pl-6">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>
<script>
    function del(id) {
        if (confirm("Bạn có chắc muốn xóa thể loại này?")) {
            $.ajax({
                url: "<?php echo Import::route_path("category.route.php") ?>",
                method: "POST",
                data: {
                    id: id,
                    action: "delete"
                },
                success: (response) => {
                    const data = JSON.parse(response)
                    if (data.status) {
                        toast("Xóa thành công", "green", 1500)
                        location.reload()
                    } else {
                        toast("Xóa thất bại", "red", 1500)
                    }
                },
            })
        }
    }

    function update(id) {
        const name = $(`#name-${id}`).val();
        if (name.length === 0) {
            alert("Yêu cầu không để trống tên thể loại");
            return
        }
        $.ajax({
            url: "<?php echo Import::route_path("category.route.php") ?>",
            method: "POST",
            data: {
                name: name,
                id: id,
                action: "update"
            },
            success: (response) => {
                const data = JSON.parse(response)
                if (data.status) {
                    toast("Cập nhật thành công", "green", 1500)
                    location.reload()
                } else {
                    toast("Cập nhật thất bại", "red", 1500)
                }
            },
        })
    }
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>