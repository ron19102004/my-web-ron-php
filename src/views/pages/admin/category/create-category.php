<!-- component -->
<div class="flex items-center justify-center p-12">
    <div class="mx-auto w-full max-w-[550px] bg-white p-4 md:p-6 rounded shadow-lg">
        <form>
            <div class="mb-5">
                <label
                    for="name"
                    class="mb-3 block text-base font-medium text-[#07074D]">
                    Tên thể loại
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Full Name"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>
            <div class="float-right">
                <button
                    id="add-category-btn"
                    class="hover:shadow-form rounded-md bg-green-700 py-3 px-8 text-base font-semibold text-white outline-none">
                    Thêm
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    $(() => {
        $("#add-category-btn").click((e) => {
            e.preventDefault()
            const name = $("#name").val();
            if (name.length === 0) {
                alert("Yêu cầu không để trống tên thể loại");
                return
            }
            $.ajax({
                url: "<?php echo Import::route_path("category.route.php") ?>",
                method: "POST",
                data: {
                    name: name,
                    action: "new"
                },
                success: (response) => {
                    const data = JSON.parse(response)
                    if (data.status) {
                        toast("Thêm thành công", "green", 1500)
                        setTimeout(() => {
                            location.reload()
                        }, 500)
                    } else {
                        toast("Thêm thất bại", "red", 1500)
                    }
                },
            })
        })
    })
</script>