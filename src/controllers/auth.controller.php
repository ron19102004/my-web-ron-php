<?php
class AuthController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function login(): Response
    {
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $phonePattern = '/^0[0-9]{9}$/';

        $data = [
            "username" => htmlspecialchars($_POST["username"]),
            "password" => htmlspecialchars($_POST["password"]),
        ];

        $user = null;
        if (preg_match($emailPattern, $data["username"])) {
            $user = $this->userRepository->findByEmail($data["username"]);
        } else if (preg_match($phonePattern, $data["username"])) {
            $user = $this->userRepository->findByPhone($data["username"]);
        } else {
            $user = $this->userRepository->findByUsername($data["username"]);
        }
        if (!$user) {
            return new Response(false, null, "Đăng nhập thất bại!");
        }
        if (!password_verify($data["password"], $user->password)) {
            return new Response(false, null, "Mật khẩu không chính xác!");
        }
        Session::set("user_id", $user->id);
        Session::set("is_authenticated", true);
        return new Response(true, null, "Đăng nhập thành công");
    }
    public function register()
    {
        try {
            $data = [
                "username" => htmlspecialchars($_POST["username"]),
                "password" => password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT),
                "email" => htmlspecialchars($_POST["email"]),
                "fullName" => htmlspecialchars($_POST["fullName"]),
                "phone" => htmlspecialchars($_POST["phone"]),
            ];
            $userByEmail = $this->userRepository->findByEmail($data["email"]);
            if ($userByEmail) {
                return new Response(false, null, "Email đã tồn tại!");
            }
            $userByPhone = $this->userRepository->findByPhone($data["phone"]);
            if ($userByPhone) {
                return new Response(false, null, "Số điện thoại đã tồn tại!");
            }
            $userByUsername = $this->userRepository->findByUsername($data["username"]);
            if ($userByUsername) {
                return new Response(false, null, "Tên đăng nhập đã tồn tại!");
            }
            $user = new User(
                0,
                $data["username"],
                $data["password"],
                $data["email"],
                $data["fullName"],
                UserRole::USER,
                $data["phone"]
            );
            $result = $this->userRepository->save($user);
            if ($result == false) {
                return new Response(false, null, "Đăng kí thất bại!");
            }
            return new Response(true, null, "Đăng kí thành công!");
        } catch (Exception $e) {
            return new Response(false, $e->getMessage(), "Đăng kí thất bại!");
        }
    }
    public function logout(): Response
    {
        session_destroy();
        return new Response(true, null, "Đăng xuất thành công");
    }
    public function changePassword()
    {
        try {
            $data = [
                "currentPassword" => htmlspecialchars($_POST["currentPassword"]),
                "newPassword" => password_hash(htmlspecialchars($_POST["newPassword"]), PASSWORD_DEFAULT),
            ];
            $userId = Session::get("user_id");
            if (!$userId) {
                return new Response(false, null, "Bạn chưa đăng nhập!");
            }
            $user = $this->userRepository->findById($userId);
            if (!$user) {
                return new Response(false, null, "Tài khoản không tồn tại!");
            }
            if (!password_verify($data["currentPassword"], $user->password)) {
                return new Response(false, null, "Mật khẩu hiện tại không chính xác!");
            }
            $result = $this->userRepository->updatePassword($userId, $data["newPassword"]);
            if ($result == false) {
                return new Response(false, null, "Đổi mật khẩu thất bại!");
            }
            return new Response(true, null, "Đổi mật khẩu thành công!");
        } catch (Exception $e) {
            return new Response(false, $e->getMessage(), "Đổi mật khẩu thất bại!");
        }
    }
    public function countRole()
    {
        try {
            $count = $this->userRepository->countRole();
            return new Response(true, $count, message: null);
        } catch (Exception $e) {
            return new Response(false, null, $e->getMessage());
        }
    }
    public function updateInfo()
    {
        try {
            $data = [
                "fullName" => htmlspecialchars($_POST["fullName"]),
                "phone" => htmlspecialchars($_POST["phone"]),
                "email" => htmlspecialchars($_POST["email"]),
            ];
            $user = $this->userRepository->findById(Session::get("user_id"));
            if (!$user) {
                return new Response(false, null, "Bạn chưa đăng nhập!");
            }
            if ($user->email!= $data["email"] && $this->userRepository->findByEmail($data["email"])) {
                return new Response(false, null, "Email đã tồn tại!");
            }
            if ($user->phone!= $data["phone"] && $this->userRepository->findByPhone($data["phone"])) {
                return new Response(false, null, "Số điện thoại đã tồn tại!");
            }
            $userUpdate = new User($user->id, $user->username, $user->password, $data["email"], $data["fullName"], $user->role, $data["phone"]);
            $result = $this->userRepository->updateInformation($userUpdate);
            if ($result == false) {
                return new Response(false, null, "Cập nhật thông tin thất bại!");
            }
            return new Response(true, null, "Cập nhật thông tin thành công!");
        } catch (Exception $e) {
            return new Response(false, $e->getMessage(), "Cập nhật thông tin thất bại!");
        }
    }
}
