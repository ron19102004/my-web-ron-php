<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="<?php echo Env::get("root-path") . "/src/views/assets/code.png" ?>" type="png">
<link rel="shortcut icon" href="<?php echo Env::get("root-path") . "/src/views/assets/code.png" ?>" type="png">
<!-- tailwindcss cdn  -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- Flowbite -->
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<!-- toastify-js -->
<script src="
https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css
" rel="stylesheet">
<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- aos  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
    function toast(message, bgColor, timeout) {
        Toastify({
            text: message,
            duration: timeout,
            newWindow: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: bgColor,
            },
        }).showToast();
    }
</script>
<?php
$_COLOR_DEF = [
    "black" => "#000000",
    "blue" => "#111827",
    "red" => "#bb2033",
    "gray" => "#E5E5E5",
    "white" => "#FFFFFF",
    "yellow" => "#fed014"
];
function isPageActive($page_path)
{
    return $_SERVER['REQUEST_URI'] == Env::get("root-path") . "/src/views/pages/" . $page_path;
}
?>
<style>
    /* CSS repository cho tất cả thẻ <pre> */
    pre {
        /* Khoảng cách bên trong */
        border-radius: 0.24rem;
        /* Bo góc để trông mềm mại hơn */
        /* Cỡ chữ dễ đọc */
        font-family: "Consolas", Courier, monospace;
        /* Sử dụng font chữ phù hợp cho mã nguồn */
        white-space: pre-wrap;
        /* Đảm bảo nội dung trong <pre> tự xuống dòng */
        word-wrap: break-word;
        /* Phá vỡ từ nếu từ quá dài */
        max-width: 100%;
        /* Giới hạn chiều rộng của thẻ <pre> để không vượt quá màn hình */
        overflow-x: auto;
        /* Thêm thanh cuộn ngang nếu nội dung quá dài */
    }

    /* Đối với mã nguồn trong thẻ pre */
    pre code {
        display: block;
        /* Đảm bảo mã nguồn hiển thị dạng block */
        color: #333;
        /* Màu chữ */
        font-size: inherit;
        /* Thừa kế cỡ chữ từ thẻ <pre> */
        overflow-x: auto;
        /* Thêm thanh cuộn nếu cần */
    }

    /* Nếu muốn phần mã có thể copy dễ dàng mà không bị ảnh hưởng bởi các khoảng trắng không cần thiết */
    pre,
    code {
        user-select: text;
        /* Cho phép chọn văn bản */
    }
</style>