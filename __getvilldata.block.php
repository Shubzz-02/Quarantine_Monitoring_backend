<?php
require_once 'config/__db_config.block.php';

class VillData
{
    private $_response = null;
    private $_param = null;
    private $_conn = null;

    public function __construct($vill_name, $block)
    {
        $this->_param = array(
            'vill_name' => strtolower($vill_name),
            'block' => $block
        );
        $this->_conn = DB_Config::getInstance()->getBlockConnection($block);
    }

    public function getVillData()
    {
        $vill_name = strtolower($this->_param['vill_name']);
        if (strpos($vill_name, " ")) {
            $vill_name = str_replace(" ", "_", $vill_name);
        }
        $query = "SELECT person_name,f_name,age, gender,p_no,c_from,r_date FROM " . $vill_name;
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