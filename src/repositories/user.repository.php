<?php
class UserRepository
{
    public function countRole()
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(" SELECT 
                                            COUNT(CASE WHEN role = 'ADMIN' THEN 1 END) AS admin_count,
                                            COUNT(CASE WHEN role = 'USER' THEN 1 END) AS user_count
                                        FROM users");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        return $result;
    }
    public function save(User $user)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare(
            "INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullName`,`phone`, `role`) 
        VALUES (NULL, :username, :password, :email, :fullName,:phone, 'USER');"
        );
        $stmt->bindParam(":username", $user->username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $user->email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $user->password, PDO::PARAM_STR);
        $stmt->bindParam(":fullName", $user->fullName, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $user->phone, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn =  null;
        return $result;
    }
    public function findByUsername(string $username): User|null
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return User::fromArray($result);
        }
        return null;
    }
    public function findByPhone(string $phone): User|null
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone = :phone");
        $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return User::fromArray($result);
        }
        return null;
    }
    public function findByEmail(string $email): User|null{
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return User::fromArray($result);
        }
        return null;
    }
    
    public function findById(int $id): User|null{
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        if ($result) {
            return User::fromArray($result);
        }
        return null;
    }
    public function updatePassword($id,$password){
        $conn = Database::connect();
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
    public function updateInformation(User $user){
        $conn = Database::connect();
        $stmt = $conn->prepare(
            "UPDATE `users` SET
            `fullName` = :fullName, 
            `phone` = :phone ,
            `email` = :email
            WHERE `id` = :id;"
        );
        $stmt->bindParam(":fullName", $user->fullName, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $user->phone, PDO::PARAM_STR);
        $stmt->bindParam(":id", $user->id, PDO::PARAM_INT);
        $stmt->bindParam(":email", $user->email, PDO::PARAM_STR);
        $result = $stmt->execute();
        $conn = null;
        return $result;
    }
}
