<?php
require_once 'config/__db_config.block.php';
require_once 'config/__functions.block.php';

class Login
{
    private $_response = null;
    private $_param = null;
    private $_conn = null;
    private $_func = null;

    public function __construct($username, $password)
    {
        $this->_param = array(
            'username' => $username,
            'password' => $password
        );
        $this->_conn = DB_Config::getInstance()->getConnection();
        $this->_func = new Functions();
    }

    public function loginUser()
    {
        $query = "SELECT full_name,block,password_hash, salt FROM login WHERE username = ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("s", $this->_param['username']);
            $stmt->execute();
            $stmt->bind_result($fullName, $block, $passwordHashDB, $salt);
            if ($stmt->fetch()) {
                if (password_verify($this->_func->concatPasswordWithSalt($this->_param['password'], $salt), $passwordHashDB)) {
                    $stmt->close();
                    $uq_key = $this->getKey($this->_param['username']);
                    $this->_response = array(
                        'status' => 0,
                        'message' => "Login successful",
                        'full_name' => $fullName,
                        'block' => $block,
                        'uq_key' => $uq_key
                    );
                } else {
                    $this->_response = array(
                        'status' => 1,
                        'message' => "Wrong Username/Password Combination"
                    );
                    $stmt->close();
                }
            } else {
                $this->_response = array(
                    'status' => 1,
                    'message' => "Wrong Username/Password Combination"
                );
                $stmt->close();
            }
        }
        return $this->_response;
    }

    private function getKey($username)
    {
        $query = "UPDATE login SET uq_key = ? WHERE username = ?";
        $uqKey = $this->_func->random(32);
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("ss", $uqKey, $username);
            $stmt->execute();
        }
        return $uqKey;
    }
}