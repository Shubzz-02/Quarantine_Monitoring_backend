<?php
require_once 'config/__db_config.block.php';

class AddPerson
{
    private $_response = null;
    private $_param = null;
    private $_conn = null;

    public function __construct($vill_name, $block, $pname, $fname, $cdate, $gender, $pno, $age, $cfrom)
    {
        $this->_param = array(
            'vill_name' => strtolower($vill_name),
            'block' => $block,
            'pname' => $pname,
            'fname' => $fname,
            'cdate' => $cdate,
            'gender' => $gender,
            'pno' => $pno,
            'age' => $age,
            'cfrom' => $cfrom
        );
        $this->_conn = DB_Config::getInstance()->getBlockConnection($block);
    }

    public function addPerson()
    {
        $vill_name = strtolower($this->_param['vill_name']);
        if (strpos($vill_name, " ")) {
            $vill_name = str_replace(" ", "_", $vill_name);
        }
        $insertQuery = "INSERT INTO " . $vill_name . "(person_name, f_name, age, gender, p_no, c_from, r_date) VALUES(?,?,?,?,?,?,?)";
        if ($stmt = $this->_conn->prepare($insertQuery)) {
            $stmt->bind_param("sssssss", $this->_param['pname'], $this->_param['fname'], $this->_param['age'], $this->_param['gender'],
                $this->_param['pno'], $this->_param['cfrom'], $this->_param['cdate']);
            $stmt->execute();
            $this->_response = array(
                'status' => 0,
                'message' => 'Person Added'
            );
            $stmt->close();
        } else {
            $this->_response = array(
                'status' => 1,
                'message' => 'Something Went Wrong'
            );
        }
        return $this->_response;
    }
}