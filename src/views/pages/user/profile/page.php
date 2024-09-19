<?php
require "../../../../utils/import.util.php";
if (!AuthMiddleware::isAuthenticated()) {
    header("Location: " . Env::get("root-path") . "/src/views/pages/auth/login/page.php");
    exit();
}
$userRepo = new UserRepository();
$user = $userRepo->findById(Session::get("user_id"));

$_METADATA = [
    "title" => "Tài khoản của tôi",
    "header-path" => "header/user-header.php",
    "footer-path" => "footer/user-footer.php"
];
require Import::view_layout_path("content/content.php") ?>

<!-- component -->
<div class="flex flex-col justify-center items-center mt-20 mb-4">
    <div class="relative flex flex-col items-center rounded-lg w-full max-w-4xl mx-auto bg-white md:shadow-lg p-6 md:border border-gray-100 ">
        <div class="w-full mb-8">
            <h4 class="text-2xl font-bold text-gray-800  ">
                Thông tin cá nhân
            </h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full" data-aos="fade-up">
            <!-- Tên đầy đủ -->
            <div class="flex flex-col rounded-lg border-gray-200 p-4 border">
                <p class="text-sm text-gray-600  ">Tên đầy đủ</p>
                <p class="text-lg font-semibold text-gray-800  ">
                    <?php echo htmlspecialchars($user->fullName); ?>
                </p>
            </div>

            <!-- Tên tài khoản -->
            <div class="flex flex-col rounded-lg border-gray-200  p-4 border " data-aos="fade-up">
                <p class="text-sm text-gray-600  ">Tên tài khoản</p>
                <p class="text-lg font-semibold text-gray-800  ">
                    <?php echo htmlspecialchars($user->username); ?>
                </p>
            </div>

            <!-- Email -->
            <div class="flex flex-col rounded-lg border-gray-200  p-4 border " data-aos="fade-up">
                <p class="text-sm text-gray-600  ">Email</p>
                <p class="text-lg font-semibold text-gray-800  ">
                    <?php echo htmlspecialchars($user->email); ?>
                </p>
            </div>

            <!-- Số điện thoại -->
            <div class="flex flex-col rounded-lg border-gray-200   p-4 border " data-aos="fade-up">
                <p class="text-sm text-gray-600  ">Số điện thoại</p>
                <p class="text-lg font-semibold text-gray-800  ">
                    <?php echo htmlspecialchars($user->phone); ?>
                </p>
            </div>

            <!-- Vai trò -->
            <div class="flex flex-col rounded-lg border-gray-200   p-4 border " data-aos="fade-up">
                <p class="text-sm text-gray-600  ">Vai trò</p>
                <div class="text-lg font-semibold text-gray-800 w-full flex ">
                    <?php if (UserRole::ADMIN == $user->role): ?>
                        <a href="<?php echo Import::view_page_path("admin/dashboard/page.php") ?>" class="w-full text-green-600 bg-green-100 px-3 py-1 rounded font-medium cursor-pointer">Admin</a>
                    <?php else: ?>
                        <a href="" class="inline-block text-green-600 bg-green-100 px-3 py-1 rounded font-medium cursor-pointer">User</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Hành động -->
            <div class="flex flex-col rounded-lg border-gray-200   p-4 border" data-aos="fade-up">
                <p class="text-sm text-gray-600  ">Hành động</p>
                <div class="font-semibold text-gray-800 w-full flex items-center gap-4">
                    <button data-modal-target="default-modal-change-pw" data-modal-toggle="default-modal-change-pw" class="w-full text-green-600 bg-green-100 px-3 py-1 rounded font-medium cursor-pointer" type="button">
                        Đổi mật khẩu
                    </button>
                    <button data-modal-target="default-modal-change-info" data-modal-toggle="default-modal-change-info" class="w-full text-green-600 bg-green-100 px-3 py-1 rounded font-medium cursor-pointer" type="button">
                        Đổi thông tin
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Đổi mật khẩu -->
<div id="default-modal-change-pw" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Đổi mật khẩu
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal-change-pw">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div>
                    <label for="current-password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại</label>
                    <input id="current-password" type="password" placeholder="Mật khẩu hiện tại" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500  ">
                </div>

                <!-- Mật khẩu mới -->
                <div>
                    <label for="new-password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                    <input id="new-password" type="password" placeholder="Mật khẩu mới" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500  ">
                </div>

                <!-- Xác nhận mật khẩu mới -->
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới</label>
                    <input id="confirm-password" type="password" placeholder="Xác nhận mật khẩu mới" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500  ">
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="default-modal-change-pw" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="changepw-btn">Xác nhận</button>
                <button data-modal-hide="default-modal-change-pw" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Hủy</button>
            </div>
        </div>
    </div>
</div>
<!-- Đổi thông tin -->
<div id="default-modal-change-info" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Đổi thông tin
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal-change-info">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tên đầy đủ
                    </label>
                    <input value="<?php echo htmlspecialchars($user->fullName); ?>" id="fullName" type="text" placeholder="Tên đầy đủ" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500  ">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Số điện thoại
                    </label>
                    <input value="<?php echo htmlspecialchars(string: $user->phone); ?>" id="phone" type="tel" placeholder="Nhập số điện thoại" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500  ">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Địa chỉ email
                    </label>
                    <input value="<?php echo htmlspecialchars($user->email); ?>" id="email" type="email" placeholder="Nhập email" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500  ">
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="default-modal-change-info" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="changeinfo-btn">Xác nhận</button>
                <button data-modal-hide="default-modal-change-info" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Hủy</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(() => {
        $("#changeinfo-btn").click(() => {
            const fullName = $("#fullName").val();
            const phone = $("#phone").val();
            const email = $("#email").val();
            if (fullName == "" || phone == "" || email == "") {
                alert("Vui lòng nhập đầy đủ thông tin!");
                return false;
            }
            $.ajax({
                url: "<?php echo Import::route_path("auth.route.php") ?>",
                type: "POST",
                data: {
                    fullName: fullName,
                    phone: phone,
                    email: email,
                    action: "update_info"
                },
                success: function(response) {
                    const data = JSON.parse(response)
                    if (data.status) {
                        toast(data.message, "green", 1000);
                        setTimeout(()=>{
                            location.reload();
                        },500)
                    } else {
                        toast(data.message, "red", 1000);
                    }
                },
            })
        })
        $("#changepw-btn").click(() => {
            const currentPassword = $("#current-password").val();
            const newPassword = $("#new-password").val();
            const confirmPassword = $("#confirm-password").val();
            if (newPassword != confirmPassword) {
                alert("Mật khẩu xác nhận không đúng!");
                return false;
            }
            $.ajax({
                url: "<?php echo Import::route_path("auth.route.php") ?>",
                type: "POST",
                data: {
                    currentPassword: currentPassword,
                    newPassword: newPassword,
                    action: "change_password"
                },
                success: function(response) {
                    const data = JSON.parse(response)
                    if (data.status) {
                        toast(data.message, "green", 1000);
                        $("#current-password").val("")
                        $("#new-password").val("")
                        $("#confirm-password").val("")
                    } else {
                        toast(data.message, "red", 1000);
                    }
                },

            })
        })
    })
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>