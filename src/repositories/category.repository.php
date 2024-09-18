<?php
class CategoryRepository
{
    private function createSlug($title) {
        // Chuyển đổi tiêu đề thành chữ thường
        $slug = strtolower($title);
        // Thay thế các ký tự không phải chữ cái hoặc số bằng dấu gạch nối
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        // Xóa các dấu gạch nối ở đầu và cuối chuỗi
        $slug = trim($slug, '-');
        $date = new DateTime();
        return $slug."-".$date->getTimestamp();
    }
    public function save(Category $category)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(
            "INSERT INTO `categories` (`id`, `name`,`slug`) 
            VALUES (NULL, :name,:slug);"
        );
        $slug = $this->createSlug($category->name);
        $stmt->bindParam(":name", $category->name, PDO::PARAM_STR);
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
    /**
     * @return array<Category>
     */
    public function find(){
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM `categories`");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        $list = [];
        foreach ($result as $row) {
            array_push($list, Category::fromArray($row));
        }
        return $list;
    }
    public function delete($id){
        $conn = Database::connect();
        $stmt = $conn->prepare("DELETE FROM categories WHERE id=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
    public function update($id,$name){
        $conn = Database::connect();
        $stmt = $conn->prepare("UPDATE categories SET name=:name,slug=:slug WHERE id=:id");
        $slug = $this->createSlug($name);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
}