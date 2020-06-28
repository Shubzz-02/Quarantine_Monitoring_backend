<?php
require_once 'config/__db_config.block.php';

class User
{
    private $_response = null;
    private $_param = null;
    private $_conn = null;

    public function __construct($username, $uq_key)
    {
        $this->_param = array(
            'username' => $username,
            'uq_key' => $uq_key
        );
        $this->_conn = DB_Config::getInstance()->getConnection();
    }

    public function verifyUser()
    {
        $query = "SELECT uq_key FROM login WHERE username = ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("s", $this->_param['username']);
            $stmt->execute();
            $stmt->bind_result($uq);
            if ($stmt->fetch()) {
                if (strcmp($this->_param['uq_key'], $uq) == 0) {
                    $stmt->close();
                    $this->_response = array(
                        'status' => 0,
                        'message' => "Authorized"
                    );
                } else {
                    $stmt->close();
                    $this->_response = array(
                        'status' => 1,
                        'message' => "Not Authorized"
                    );
                }
            } else {
                $this->_response = array(
                    'status' => 1,
                    'message' => "Something went wrong"
                );
            }
        }
        return $this->_response;
    }

    public function getBlock()
    {
        $query = "SELECT block FROM login WHERE username = ? and uq_key = ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("ss", $this->_param['username'], $this->_param['uq_key']);
            $stmt->execute();
            $stmt->bind_result($block);
            if ($stmt->fetch()) {
                $stmt->close();
                return $block;
            }
            $stmt->close();
            return null;
        }
        return null;
    }

    public function getId()
    {
        $query = "SELECT uq_id FROM login WHERE username = ? and uq_key = ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("ss", $this->_param['username'], $this->_param['uq_key']);
            $stmt->execute();
            $stmt->bind_result($id);
            if ($stmt->fetch()) {
                $stmt->close();
                return $id;
            }
            $stmt->close();
            return null;
        }
        return null;
    }

    public function getVillName($id, $block)
    {
        $iid = (int)$id;
        if (strcmp($block,"Agustyamuni") == 0) {
            $query = "SELECT vill_name FROM Agustyamuni where uq_id = ?";
        } else if (strcmp($block,"Jakholi") == 0) {
            $query = "SELECT vill_name FROM Jakholi where uq_id = ?";
        } else {
            $query = "SELECT vill_name FROM Ukhimath where uq_id = ?";
        }
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("i", $iid);
            $stmt->execute();
            $stmt->bind_result($vill_name);
            if ($stmt->fetch()) {
                return $vill_name;
            }
        }
        return null;
    }

}