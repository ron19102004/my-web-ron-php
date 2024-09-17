<?php
class AuthMiddleware{
    public static function getRoleCurrent()
    {
      $id = Session::get("user_id");
      if (!$id) {
        return null;
      }
      $conn = Database::connect();
      $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
      $stmt->bindParam(':id', $id);
      $id = intval($id);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $conn = null;
      if ($result) {
        return User::fromArray(data: $result)->role;
      }
      return null;
    }
    public static function isAuthenticated(){
        if(Session::get("is_authenticated") == null || Session::get("is_authenticated") == false){
            return false;
        }
        return true;
    }
    public static function hasRoles(array $roles){
        $roleCurrent = AuthMiddleware::getRoleCurrent();
        if (in_array($roleCurrent, $roles) == false) {
          return false;
        }
        return true;
    }
}