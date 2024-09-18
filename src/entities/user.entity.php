<?php
enum UserRole: string
{
    case ADMIN = "ADMIN";
    case USER = "USER";
}
class User
{
    public $id, $username, $password, $email, $fullName, $role,$phone;
    public function __construct(int $id, string $username, string $password, string $email, string $fullName, string $role, string $phone)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->role = $role;
        $this->phone = $phone;
    }
    public static function fromArray(array $data): User
    {
        return new User(
            $data['id'],
            $data['username'],
            $data['password'],
            $data['email'],
            $data['fullName'],
            $data['role'],
            $data['phone']
        );
    }
}
