<?php
require_once 'config/__db_config.block.php';

class AddVill
{
    private $_response = null;
    private $_param = null;
    private $_conn = null;

    public function __construct($username, $uq_key, $vill_name, $block, $id)
    {
        $this->_param = array(
            'username' => $username,
            'uq_key' => $uq_key,
            'vill_name' => $vill_name,
            'block' => $block,
            'id' => $id,
            'tot_person' => "0"
        );
        $this->_conn = DB_Config::getInstance()->getConnection();
    }

    public function addVill()
    {
        if ($this->checkPermission() == 0) {
            if (strcmp($this->_param['block'], "Agustyamuni") == 0) {
                $insertQuery = "INSERT INTO Agustyamuni(vill_name, tot_person, uq_id) VALUES(?,?,?)";
            } else if (strcmp($this->_param['block'], "Jakholi") == 0) {
                $insertQuery = "INSERT INTO Jakholi(vill_name, tot_person, uq_id) VALUES(?,?,?)";
            } else {
                $insertQuery = "INSERT INTO Ukhimath(vill_name, tot_person, uq_id) VALUES(?,?,?)";
            }
            if ($stmt = $this->_conn->prepare($insertQuery)) {
                $stmt->bind_param("ssi", $this->_param['vill_name'], $this->_param['tot_person'], $this->_param['id']);
                $stmt->execute();
                $this->_response = array(
                    'status' => 0,
                    'message' => "Village Added"
                );
                $stmt->close();
                $this->createTable();
                $this->updatePermisssion();
            }
        } else {
            $this->_response = array(
                'status' => 9,
                'message' => "No permission"
            );
        }
        return $this->_response;
    }

    private function checkPermission()
    {
        $query = "SELECT count FROM login WHERE username = ? and uq_key = ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("ss", $this->_param['username'], $this->_param['uq_key']);
            $stmt->execute();
            $stmt->bind_result($cd);
            if ($stmt->fetch()) {
                $stmt->close();
                return $cd;
            }
            $stmt->close();
            return 0;
        }
        return 0;
    }

    private function updatePermisssion()
    {
        $iid = $this->_param['id'];
        $query = "UPDATE login SET count=1 WHERE uq_id= ?";
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->bind_param("i", $iid);
            $stmt->execute();
        }
    }

    private function createTable()
    {
        //echo $this->_param['block'];
        $conn = DB_Config::getInstance()->getBlockConnection($this->_param['block']);
        $vill_name = strtolower($this->_param['vill_name']);
        //$vill_name = preg_replace("/[\S]","_",strtolower(trim($this->_param['vill_name'])));
        if (strpos($vill_name, " ")) {
            $vill_name = str_replace(" ", "_", $vill_name);
        }
        $sql = "CREATE TABLE " . $vill_name . "( s_no INT(255) NOT NULL AUTO_INCREMENT , person_name TEXT NOT NULL , f_name TEXT NOT NULL , age TEXT NOT NULL , gender TEXT NOT NULL , p_no TEXT NOT NULL , c_from TEXT NOT NULL , r_date TEXT NOT NULL , PRIMARY KEY (s_no)) ENGINE = InnoDB";
        //echo $sql;
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

}