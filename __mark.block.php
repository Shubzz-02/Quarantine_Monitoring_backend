<?php
require_once 'config/__db_config.block.php';

class Mark
{
    private $_response = null;
    private $_param = null;
    private $_arr = array();
    private $_conn = null;

    public function __construct($vill_name, $block, $inputJSON)
    {
        $this->_param = array(
            'vill_name' => trim($vill_name),
            'block' => $block,
        );
        $this->_arr = json_decode($inputJSON, true);
        $this->_conn = DB_Config::getInstance()->getBlockConnection($block);
    }

    public function markAtted()
    {
        $vill_name = strtolower($this->_param['vill_name']);
        if (strpos($vill_name, " ")) {
            $vill_name = str_replace(" ", "_", $vill_name);
        }
        if ($this->alterTable($vill_name)) {
            $ct = 0;
            for ($i = 0; $i < count($this->_arr); $i++) {
                $arrr = $this->_arr[$i];
                if ($this->insertData($arrr, $vill_name)) {
                    $ct++;
                }
            }
            if ($ct == count($this->_arr)) {
                $this->_response = array(
                    'status' => 0,
                    'message' => "Data Suceed"
                );
            } else {
                $this->_response = array(
                    'status' => 9,
                    'message' => "Data Failed"
                );
            }
        } else {
            $this->_response = array(
                'status' => 99,
                'message' => "Some error occured"
            );
        }
        return $this->_response;
    }

    private function alterTable($vill_name)
    {
    	date_default_timezone_set("Asia/Kolkata");
        $date = date("Y_m_d");
        $prq = $date . "_isfccf TEXT NULL , " . $date . "_aav TEXT NULL , " . $date . "_ciclp TEXT NULL , " . $date . "_sfcf TEXT NULL)";
        $alterTable = "ALTER TABLE " . $vill_name . " ADD  (" . $prq;
        if (mysqli_query($this->_conn, $alterTable)) {
            return true;
        } else {
            return false;
        }
    }

    private function insertData($arrr, $vill_name)
    {
    	date_default_timezone_set("Asia/Kolkata");
        $date = date("Y_m_d");
        $prq = $date . "_isfccf=? , " . $date . "_aav=? , " . $date . "_ciclp=? , " . $date . "_sfcf=? ";
        $updateQuery = "UPDATE " . $vill_name . " SET " . $prq . " WHERE person_name=? and p_no=? and age=?";
        if ($stmt = $this->_conn->prepare($updateQuery)) {
            $stmt->bind_param("sssssss", $arrr[3], $arrr[4], $arrr[5], $arrr[6], $arrr[0], $arrr[1], $arrr[2]);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            return false;
        }
    }
}