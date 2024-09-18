<?php
require  "../../../../utils/import.util.php";

$_METADATA = [
    "title" => "Dashboard",
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
                            Dashboard
                        </h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = ! dropdownOpen"
                            class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                            <img class="object-cover w-full h-full"
                                src="<?php echo Import::view_assets_path("code.png") ?>"
                                alt="Your avatar">
                        </button>

                        <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"
                            style="display: none;"></div>

                        <div x-show="dropdownOpen"
                            class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl"
                            style="display: none;">
                            <a href="<?php echo Env::get("root-path") ?>/"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                                Thoát khỏi trình quản lý
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 ">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-6">
                    <div>
                        <canvas id="countRole"></canvas>
                    </div>
                    <div>
                        <canvas id="countPosts"></canvas>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<!-- countRole -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('countRole');
    const roleChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Admin', 'Người dùng'],
            datasets: [{
                label: 'Số lượng',
                data: [12, 19],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function loadCountRoleChart() {
        $.ajax({
            url: "<?php echo Import::route_path("auth.route.php") ?>",
            method: "GET",
            data: {
                action: "countRole",
            },
            success: (response) => {
                const data = JSON.parse(response)
                if (data.status) {
                    console.log(data);
                    roleChart.data.datasets[0].data = [
                        data.data.admin_count,
                        data.data.user_count
                    ]
                    roleChart.update()
                }
            },
        })
    }
    loadCountRoleChart()
</script>
<!-- countPosts -->
<script>
    const ctx2 = document.getElementById('countPosts');
    const postChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Bài viết'],
            datasets: [{
                label: 'Số lượng',
                data: [12],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function loadCountPostChart() {
        $.ajax({
            url: "<?php echo Import::route_path("post.route.php") ?>",
            method: "GET",
            data: {
                action: "countPosts",
            },
            success: (response) => {
                const data = JSON.parse(response)
                if (data.status) {
                    console.log(data);
                    postChart.data.datasets[0].data = [
                        data.data,
                    ]
                    postChart.update()
                }
            },
        })
    }
    loadCountPostChart()
</script>
<?php require Import::view_layout_path("content/end-content.php") ?>