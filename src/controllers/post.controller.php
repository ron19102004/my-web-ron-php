<?php
class PostController
{
    private $postRepo;
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }
    public function add()
    {
        try {
            $data = [
                "title" => htmlspecialchars($_POST["title"]),
                "context" => htmlspecialchars($_POST["context"]),
                "category_id" => htmlspecialchars($_POST["category_id"])
            ];
            $post = new Post(0, $data["title"], $data["context"], $data["category_id"], "", 0,"");
            $result = $this->postRepo->save($post);
            if ($result) {
                return new Response(true, $post, "Tạo bài viết thành công!.");
            }
            return new Response(false, null, "Tạo bài viết thất bại!");
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function getAll(){
        try {
            $page = htmlspecialchars($_GET["page"]);
            $posts = $this->postRepo->find($page);
            return new Response(true, $posts, message: null);
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function getAllForAdmin(){
        try {
            $page = htmlspecialchars($_GET["page"]);
            $posts = $this->postRepo->findForAdmin($page);
            return new Response(true, $posts, message: null);
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function getByCategoryId()
    {
        try {
            $categoryId = htmlspecialchars($_GET["category_id"]);
            $page = htmlspecialchars($_GET["page"]);
            $posts = $this->postRepo->findByCategoryId($categoryId, $page);
            return new Response(true, $posts, message: null);
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function getByCategoryIdForAdmin()
    {
        try {
            $categoryId = htmlspecialchars($_GET["category_id"]);
            $page = htmlspecialchars($_GET["page"]);
            $posts = $this->postRepo->findByCategoryIdForAdmin($categoryId, $page);
            return new Response(true, $posts, message: null);
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function findById(){
        try {
            $id = htmlspecialchars($_GET["id"]);
            $post = $this->postRepo->findByPostId($id);
            return new Response(true, $post, message: null);
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function delete(){
        try {
            $id = htmlspecialchars($_POST["id"]);
            $result = $this->postRepo->delete($id);
            if ($result) {
                return new Response(true, null, "Xóa bài viết thành công!");
            }
            return new Response(false, null, "Xóa bài viết thất bại!");
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function hidden(){
        try {
            $id = htmlspecialchars($_POST["id"]);
            $value = htmlspecialchars($_POST["value"]);
            $result = $this->postRepo->hiddenPostUpdateById($id,$value);
            if ($result) {
                return new Response(true, null, "Ẩn bài viết thành công!");
            }
            return new Response(false, null, "Ẩn bài viết thất bại!");
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function update(){
        try {
            $data = [
                "title" => htmlspecialchars($_POST["title"]),
                "context" => htmlspecialchars($_POST["context"]),
                "category_id" => htmlspecialchars($_POST["category_id"]),
                "id" => htmlspecialchars($_POST["id"])
            ];
            $result = $this->postRepo->update($data["id"],$data["title"],$data["context"],$data["category_id"]);
            if ($result) {
                return new Response(true, null, "Cập nhật bài viết thành công!");
            }
            return new Response(false, null, "Cập nhật bài viết thất bại!");
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
}
