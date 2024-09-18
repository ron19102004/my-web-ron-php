<?php
class CategoryRepository
{
    public function save(Category $category)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(
            "INSERT INTO `categories` (`id`, `name`,`slug`) 
            VALUES (NULL, :name,:slug);"
        );
        $slug = Slugify::slugify($category->name);
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
        $slug = Slugify::slugify($name);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
}