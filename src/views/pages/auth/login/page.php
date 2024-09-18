<?php
require "../../../../utils/import.util.php";

if(AuthMiddleware::isAuthenticated()){
    header("Location: ".Env::get("root-path")."/src/views/pages/user/home/page.php");
}

$_METADATA = [
    "title" => "Đăng nhập",
    "header-path"=>"header/auth-header.php"
];
require Import::view_layout_path("content/content.php") ?>
<!-- component -->
<div class="min-h-screen flex justify-center items-center bg-white">
    <div class="p-10 md:border-[1px] -mt-10 border-slate-200 rounded-md flex flex-col items-center space-y-3">
        <div class="py-8">
            <h1 class="text-3xl font-bold text-[#0070ba]">Welcome</h1>
        </div>
        <input id="username" type="text" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="E-Mail or Phone number" />
        <div class="flex flex-col space-y-1">
            <input id="pw" type="password" class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Password" />
            <p class="font-bold text-[#0070ba]">Forgot password?</p>
        </div>
        <div class="flex flex-col space-y-5 w-full">
            <button id="btn-submit" class="w-full bg-[#0070ba] rounded-3xl p-3 text-white font-bold transition duration-200 hover:bg-[#003087]">Log in</button>
            <div class="flex items-center justify-center border-t-[1px] border-t-slate-300 w-full relative">
                <div class="-mt-1 font-bod bg-white px-5 absolute">Or</div>
            </div>
            <a href="../register/page.php" class="text-center w-full border-blue-900 hover:border-[#003087] hover:border-[2px] border-[1px] rounded-3xl p-3 text-[#0070ba] font-bold transition duration-200">Sign Up</a>
        </div>
    </div>
</div>
<script>
    $(() => {
        $("#btn-submit").click(() => {
            let pw = $("#pw").val()
            const data = {
                "password": pw,
                "username": $("#username").val(),
                "action": "login"
            }
            $.ajax({
                url: "<?php echo Import::route_path("auth.route.php") ?>",
                method: "POST",
                data: data,
                success: (data) => {
                    
                    const res = JSON.parse(data);
                    if (res.status) {
                        window.location.href = "<?php echo Env::get("root-path")?>/";
                    }
                    toast(res.message, res.status ? "green" : "red", 1500)
                }
            })
        })
    })
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>