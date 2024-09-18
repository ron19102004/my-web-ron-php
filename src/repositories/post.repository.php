<?php
class PostRepository
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
    public function save(Post $post)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(
            "INSERT INTO `posts` (`id`, `title`, `context`, `category_id`, `created_at`,`hidden`,`slug`) 
            VALUES (NULL, :title, :context, :category_id, NOW(),0,:slug);"
        );
        //nén dữ liệu
        $compressed_data = gzcompress($post->context);
        $encoded_data = base64_encode($compressed_data);

        $slug = $this->createSlug($post->title);

        $stmt->bindParam(":title", $post->title, PDO::PARAM_STR);
        $stmt->bindParam(":context", $encoded_data, PDO::PARAM_STR);
        $stmt->bindParam(":category_id", $post->category_id, PDO::PARAM_INT);
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
    public function findByCategoryId($category_id, $page)
    {
        $offset = ($page - 1) * 10;
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE p.category_id = :category_id AND p.hidden = 0 ORDER BY p.id DESC LIMIT 10 OFFSET :offset");
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        $list = [];
        foreach ($result as $row) {
            array_push($list, [
                "post" => Post::fromArray($row),
                "category" => [
                    "name" => $row["name"],
                    "slug" => $row["cate_slug"],
                    "id" => $row["cate_id"],
                ],
            ]);
        }
        return $list;
    }
    public function findByCategorySlug($slug, $page)
    {
        $offset = ($page - 1) * 10;
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE c.slug = :slug AND p.hidden = 0 ORDER BY p.id DESC LIMIT 10 OFFSET :offset");
        $stmt->bindParam(":slug", $slug, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        $list = [];
        foreach ($result as $row) {
            array_push($list, [
                "post" => Post::fromArray($row),
                "category" => [
                    "name" => $row["name"],
                    "slug" => $row["cate_slug"],
                    "id" => $row["cate_id"],
                ],
            ]);
        }
        return $list;
    }
    public function findByCategoryIdForAdmin($category_id, $page)
    {
        $offset = ($page - 1) * 10;
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE p.category_id = :category_id ORDER BY p.id DESC LIMIT 10 OFFSET :offset");
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        $list = [];
        foreach ($result as $row) {
            array_push($list, [
                "post" => Post::fromArray($row),
                "category" => [
                    "name" => $row["name"],
                    "slug" => $row["cate_slug"],
                    "id" => $row["cate_id"],
                ],
            ]);
        }
        return $list;
    }
    public function find($page)
    {
        $offset = ($page - 1) * 10;
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE p.hidden = 0 ORDER BY p.id DESC LIMIT 10 OFFSET :offset");
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        $list = [];
        foreach ($result as $row) {
            array_push($list, [
                "post" => Post::fromArray($row),
                "category" => [
                    "name" => $row["name"],
                    "slug" => $row["cate_slug"],
                    "id" => $row["cate_id"],
                ],
            ]);
        }
        return $list;
    }
    public function findForAdmin($page)
    {
        $offset = ($page - 1) * 10;
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        ORDER BY p.id DESC LIMIT 10 OFFSET :offset");
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        $list = [];
        foreach ($result as $row) {
            array_push($list, [
                "post" => Post::fromArray($row),
                "category" => [
                    "name" => $row["name"],
                    "slug" => $row["cate_slug"],
                    "id" => $row["cate_id"],
                ],
            ]);
        }
        return $list;
    }
    public function findByPostId($postId)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE p.id = :id AND hidden = 0");
        $stmt->bindParam(":id", $postId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return [
                "post" => Post::fromArray($result),
                "category" =>[
                    "name" => $result["name"],
                    "slug" => $result["cate_slug"],
                    "id" => $result["cate_id"],
                ],
            ];
        }
        return null;
    }
    public function findNewLeastRecentPosts(){
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE hidden = 0 ORDER BY p.id DESC");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return [
                "post" => Post::fromArray($result),
                "category" =>[
                    "name" => $result["name"],
                    "slug" => $result["cate_slug"],
                    "id" => $result["cate_id"],
                ],
            ];
        }
        return null;
    }
    
    public function findByPostSlug($slug)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT p.*,c.name,c.slug as cate_slug,c.id as cate_id FROM posts p
        INNER JOIN categories c ON c.id = p.category_id
        WHERE p.slug = :slug AND hidden = 0");
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return [
                "post" => Post::fromArray($result),
                "category" => [
                    "name" => $result["name"],
                    "slug" => $result["cate_slug"],
                    "id" => $result["cate_id"],
                ],
            ];
        }
        return null;
    }
    public function delete($id)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("DELETE FROM `posts` WHERE `id`=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
    public function hiddenPostUpdateById($id, $value)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(" UPDATE posts SET hidden = :hidden WHERE id=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":hidden", $value, PDO::PARAM_INT);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
    public function update($id, $title, $context, $categoryId)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("UPDATE posts SET title=:title, context=:context, category_id=:categoryId, slug =:slug WHERE id=:id");

        //nén dữ liệu
        $compressed_data = gzcompress($context);
        $encoded_data = base64_encode($compressed_data);

        $slug = $this->createSlug($title);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":context", $encoded_data, PDO::PARAM_STR);
        $stmt->bindParam(":categoryId", $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);

        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
}
