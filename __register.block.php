<?php
require_once 'config/__db_config.block.php';
require_once 'config/__functions.block.php';

class Register
{
    private $_response = null;
    private $_input = null;
    private $_param = null;
    private $_conn = null;
    private $_func = null;

    public function __construct($full_name, $username, $password, $block)
    {
        $this->_param = array(
            'username' => $username,
            'password' => $password,
            'full_name' => $full_name,
            'block' => $block
        );
        $this->_conn = DB_Config::getInstance()->getConnection();
        $this->_func = new Functions();
    }

    public function registerUser()
    {
        if (!$this->userExists()) {
            $salt = $this->_func->getSalt();
            $passwordHash = password_hash($this->_func->concatPasswordWithSalt($this->_param['password'], $salt), PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO login(username,full_name,block,password_hash, salt) VALUES (?,?,?,?,?)";
            if ($stmt = $this->_conn->prepare($insertQuery)) {
                $stmt->bind_param("sssss", $this->_param['username'], $this->_param['full_name'], $this->_param['block'], $passwordHash, $salt);
                $stmt->execute();
                $this->_response = array(
                    'status' => 0,
                    'message' => "User Created"
                );
                $stmt->close();
            }
        } else {
            $this->_response = array(
                'status' => 1,
                'message' => "User exists"
            );
        }
        return $this->_response;
    }

    private function userExists()
    {
        $query = "SELECT username FROM login WHERE username = ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("s", $this->_param['username']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();
            if ($stmt->num_rows == 1) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }
}