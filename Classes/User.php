<?php
class user
{
    private $pdo;
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    ////////////////////////////////////////////

    public function validateUsername()
    {
        return strlen($this->name) >= 3;
    }

    public function validateEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function validatePassword()
    {
        return strlen($this->password) >= 8;
    }

    public function validateAll()
    {
        return $this->validateUsername()
            && $this->validateEmail()
            && $this->validatePassword();
    }

    ////////////////////////////////////////////

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    ////////////////////////////////////////////

    public function push()
    {
        $sql = "INSERT INTO users (username, email, password)
                    VALUES (:username, :email, :password)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password
        ]);
    }

    ////////////////////////////////////////////

    private function verify_password($password, $stored_hash)
    {
        return password_verify($password, $stored_hash);
    }

    public function LoadByEmail($email, $password)
    {
        $sql = "SELECT id, username, email, password
                    FROM users WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            
            $id = $row['id'];
            $stored_hash = $row['password'];
            $username = $row['username'];

            if ($this->verify_password($password, $stored_hash)) {
                $this->id = $id;
                $this->setName($username);
                $this->setEmail($email);
                $this->setPassword($password);

                $_SESSION['logged_in'] = true;
                $_SESSION['login_id'] = $id;

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    ////////////////////////////////////////////

    public function calc_balance() {}
}
