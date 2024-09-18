<?php
class CategoryController
{
    private $categoryRepo;
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }
    public function add()
    {
        try {
            $data = [
                "name" => htmlspecialchars($_POST["name"])
            ];
            $cate = new Category(0, $data["name"],"");
            $result = $this->categoryRepo->save($cate);
            if ($result) {
                return new Response(true, $cate, "Tạo thể loại thành công!.");
            }
            return new Response(false, null, "Tạo thể loại thất bại!");
        } catch (Exception $e) {
            return new Response(false,  $e->getMessage(), "Lỗi khi tạo thể loại!");
        }
    }
    public function update(){
        try {
            $data = [
                "name" => htmlspecialchars($_POST["name"]),
                "id" => htmlspecialchars($_POST["id"])
            ];
            $result = $this->categoryRepo->update($data["id"], $data["name"]);
            if ($result) {
                return new Response(true, null, "Cập nhật thể loại thành công!.");
            }
            return new Response(false, null, "Cập nhật thể loại thất bại!");
        } catch (Exception $e) {
            return new Response(false,  $e->getMessage(), "Lỗi khi cập nhật thể loại!");
        }
    }
    public function delete(){
        try {
            $id = htmlspecialchars($_POST["id"]);
            $result = $this->categoryRepo->delete($id);
            if ($result) {
                return new Response(true, null, "Xóa thể loại thành công!.");
            }
            return new Response(false, null, "Xóa thể loại thất bại!");
        } catch (Exception $e) {
            return new Response(false,  $e->getMessage(), "Lỗi khi xóa thể loại!");
        }
    }
}
