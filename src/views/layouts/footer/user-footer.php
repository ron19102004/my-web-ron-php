<footer class="bg-gray-900 text-white py-8" data-aos="fade-up">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">

        <!-- Brand / Logo -->
        <div class="mb-6 md:mb-0">
            <h2 class="text-2xl font-bold">Liên hệ với chúng tôi</h2>
        </div>

        <!-- Social Media Links -->
        <div class="flex space-x-4 mb-6 md:mb-0">
            <!-- Facebook -->
            <a href="<?php echo Env::get("contact")["fb"]?>" class="text-blue-500 hover:text-blue-400" target="_blank">
                <i class="fab fa-facebook-f fa-2x"></i>
            </a>

            <!-- Zalo -->
            <a href="<?php echo Env::get("contact")["zalo"]?>" class="text-blue-600 hover:text-blue-500" target="_blank">
                <i class="fab fa-zalo fa-2x"></i> <!-- Zalo Icon nếu bạn có, nếu không có bạn có thể thay bằng 1 icon khác -->
            </a>

            <!-- Email -->
            <a href="mailto:<?php echo Env::get("contact")["mail"]?>" class="text-red-500 hover:text-red-400">
                <i class="fas fa-envelope fa-2x"></i>
            </a>
        </div>

        <!-- Contact Information -->
        <div class="text-center md:text-right">
            <p class="mb-2">Email: <?php echo Env::get("contact")["mail"]?></p>
            <p>SĐT: <?php echo Env::get("contact")["sdt"]?></p>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="text-center border-t border-gray-700 mt-8 pt-4">
        <p class="text-gray-500 text-sm">©2024 Trần Ngọc Anh Dũng.</p>
    </div>
</footer>