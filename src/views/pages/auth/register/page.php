<?php
require "../../../../utils/import.util.php";
if (AuthMiddleware::isAuthenticated()) {
    header("Location: " . Env::get("root-path") . "/src/views/pages/user/home/page.php");
}
$_METADATA = [
    "title" => "Đăng ký",
];
require Import::view_layout_path("content/content.php") ?>
<!-- component -->
<div class="min-h-screen flex justify-center items-center bg-white">
    <div class="md:p-10 md:border-[1px] -mt-10 border-slate-200 rounded-md flex flex-col items-center space-y-3">
        <div class="py-8 flex flex-col justify-center items-center">
            <a href="<?php echo Env::get("root-path") ?>/" class="text-3xl flex justify-start items-center">
                <img src="<?php echo Import::view_assets_path("code.png") ?>" alt="logo" class="w-10 h-10">
            </a>
            <h1 class="text-3xl font-bold text-[#0070ba]">Welcome</h1>
        </div>
        <input id="fullName" type="text" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Tên đầy đủ" />
        <input id="username" type="text" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Tên tài khoản" />
        <input id="email" type="email" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Địa chỉ email" />
        <input id="phone" type="tel" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Số điện thoại" />
        <input id="pw" type="password" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Mật khẩu" />
        <input id="confirm-pw" type="password" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Xác thực mật khẩu" />
        <div class="flex flex-col space-y-5 w-full">
            <button id="submit-btn" class="w-full bg-[#0070ba] rounded-3xl p-3 text-white font-bold transition duration-200 hover:bg-[#003087]">Submit</button>
            <div class="flex items-center justify-center border-t-[1px] border-t-slate-300 w-full relative">
                <div class="-mt-1 font-bod bg-white px-5 absolute">Or</div>
            </div>
            <a href="../login/page.php" class="text-center w-full border-blue-900 hover:border-[#003087] hover:border-[2px] border-[1px] rounded-3xl p-3 text-[#0070ba] font-bold transition duration-200">Sign In</a>
        </div>
    </div>

</div>
<script>
    $(() => {
        $("#submit-btn").click(() => {
            let pw = $("#pw").val()
            let confirmPw = $("#confirm-pw").val()
            if (pw != confirmPw) {
                toast("Mật khẩu xác thực hông khớp", "red", 1500)
                return
            }
            const data = {
                "password": pw,
                "username": $("#username").val(),
                "fullName": $("#fullName").val(),
                "email": $("#email").val(),
                "phone": $("#phone").val(),
                "action": "register"
            }
            $.ajax({
                url: "<?php echo Import::route_path("auth.route.php") ?>",
                method: "POST",
                data: data,
                success: (data) => {
                    console.log(data);

                    const res = JSON.parse(data);
                    if (res.status) {
                        window.location.href = "<?php echo Import::view_page_path("auth/login/page.php") ?>";
                    }
                    toast(res.message, res.status ? "green" : "red", 1500)
                }
            })
        })
    })
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>