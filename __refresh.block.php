<?php

require_once 'config/__db_config.block.php';

class Refresh
{
    private $_response = null;
    private $_param = null;
    private $_conn = null;

    public function __construct($username, $uq_key, $block)
    {
        $this->_param = array(
            'username' => $username,
            'uq_key' => $uq_key,
            'block' => $block
        );
        $this->_conn = DB_Config::getInstance()->getConnection();
    }

    public function refresh()
    {
        if ($this->_param['block'] != null) {
            $data = $this->getVillDetails($this->_param['block']);
            if ($data != null) {
                $d = base64_decode($data);
                $this->_response = json_decode($d, true);
                return $this->_response;
            }
        } else {
            $this->_response = array(
                'status' => 1,
                'message' => "Something went wrong"
            );
        }
        return $this->_response;
    }

    function getVillDetails($block)
    {
        if (strcmp($block, "Agustyamuni") == 0) {
            $query = "SELECT vill_name,tot_person FROM Agustyamuni";
        } else if (strcmp($block, "Jakholi") == 0) {
            $query = "SELECT vill_name,tot_person FROM Jakholi";
        } else {
            $query = "SELECT vill_name,tot_person FROM Ukhimath";
        }
        if ($stmt = $this->_conn->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
            $outp = $result->fetch_all(MYSQLI_ASSOC);
            $data = base64_encode(json_encode($outp));
            return $data;
        }
        return null;
    }
}