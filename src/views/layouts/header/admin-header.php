<?php 
if(!AuthMiddleware::hasRoles([UserRole::ADMIN])){
    header("Location: /ron/src/views/pages/auth/login/page.php");
    exit();
}
?>
<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-[<?php echo $_COLOR_DEF["blue"] ?>] lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <span class="mx-2 text-2xl font-semibold text-white">Quản lý</span>
        </div>
    </div>

    <nav class="mt-10">
        <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-opacity-25 
        <?php echo (isPageActive("admin/dashboard/page.php") ? "bg-gray-700" : "hover:bg-gray-700") ?>"
            href="<?php echo Import::view_page_path("admin/dashboard/page.php") ?>">
            <i class="fa-solid fa-house"></i>
            <span class="mx-3">Trang chủ</span>
        </a>
        <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-opacity-25 
        <?php echo (isPageActive("admin/category/page.php") ? "bg-gray-700" : "hover:bg-gray-700") ?>"
            href="<?php echo Import::view_page_path("admin/category/page.php") ?>">
            <i class="fa-solid fa-list"></i>
            <span class="mx-3">Thể loại</span>
        </a>
        <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-opacity-25 
        <?php echo (isPageActive("admin/posts/page.php") ? "bg-gray-700" : "hover:bg-gray-700") ?>"
            href="<?php echo Import::view_page_path("admin/posts/page.php") ?>">
            <i class="fa-solid fa-file-signature"></i>
            <span class="mx-3">Bài viết</span>
        </a>
        <button id="logout" class="w-full flex items-center px-6 py-2 mt-4 text-gray-100 bg-opacity-25 hover:bg-gray-700">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="mx-3">Đăng xuất</span>
        </button>
    </nav>
</div>
<script>
    $(() => {
        $("#logout").click(function() {
            $.ajax({
                url: "<?php echo Import::route_path("auth.route.php") ?>",
                method: "POST",
                data: {
                    action: "logout"
                },
                success: function(response) {
                    const data = JSON.parse(response)
                    if (data.status) {
                        window.location.href = "/";
                    } else {
                        toast("Đăng xuất thất bại!", "red", 1500)
                    }
                }
            })
        })
    })
</script>