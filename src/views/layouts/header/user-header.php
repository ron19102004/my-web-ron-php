<?php
Import::entities(["category.entity.php"]);
Import::repositories(["category.repository.php"]);

$cateRepo = new CategoryRepository();
$cates = $cateRepo->find();
?>

<nav class="bg-white md:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?php echo Env::get("root-path")?>/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap md:text-white ">Ron</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <?php if (AuthMiddleware::isAuthenticated()): ?>
                <button id="logout" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Đăng xuất
                </button>
            <?php else: ?>
                <a href="<?php echo Import::view_page_path("auth/login/page.php")?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Đăng nhập
                </a>
            <?php endif; ?>
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 bg-gray-900">
                <li>
                    <a href="<?php echo Import::view_page_path("user/home/page.php") ?>"
                        class="block py-2 px-3 rounded md:bg-transparent md:p-0 
                    <?php echo (isPageActive("user/home/page.php") ? " text-blue-700" : "text-white hover:text-blue-700") ?>
                    " aria-current="page">Trang chủ</a>
                </li>
                <li>
                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class=" py-2 px-3 rounded md:bg-transparent md:p-0 text-white hover:text-blue-700 flex items-center" type="button">Thể loại<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <?php foreach ($cates as $cate): ?>
                                <li>
                                    <a href="<?php echo Import::view_page_path("user/posts/category.php") . "?slug=" . $cate->slug ?>" class="block px-4 py-2 hover:bg-gray-700  dark:hover:text-white hover:underline"><?php echo $cate->name ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </li>
                <li>
                    <a href="<?php echo Import::view_page_path("user/profile/page.php") ?>"
                        class="block py-2 px-3  rounded md:bg-transparent md:p-0 
                    <?php echo (isPageActive("user/profile/page.php") ? " text-blue-700" : "text-white hover:text-blue-700") ?>
                    " aria-current="page">Tài khoản</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
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
                        window.location.href = "<?php echo Env::get("root-path")?>/";
                    } else {
                        toast("Đăng xuất thất bại!", "red", 1500)
                    }
                }
            })
        })
    })
</script>