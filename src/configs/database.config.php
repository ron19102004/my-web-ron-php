<?php
class Database
{
    /**
     * @return PDO|null
     */
    public static function connect()
    {
        $meta_data = Env::get("db");
        $servername = $meta_data["host"];
        $username =  $meta_data["username"];
        $password =  $meta_data["password"];
        $dbname =  $meta_data["name"];
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $conn;
    }
}
