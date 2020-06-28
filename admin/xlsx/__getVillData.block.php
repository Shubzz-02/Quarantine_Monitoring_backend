<?php
require_once 'config/__db_config.block.php';

class GetVillData
{
    private $block;
    private $vill_name;
    private $con;


    public function __construct($block)
    {
        $this->block = $block;
        $this->con = DB_Config::getInstance()->getBlockConnection($block);
    }

    public function getVillname()
    {
        $tables = array_column(mysqli_fetch_all($this->con->query('SHOW TABLES')), 0);
        if ($tables == null) {
            return null;
        } else {
            return $tables;
        }
    }

    public function getTableData($vill_name)
    {
        $query = "SELECT * from " . $vill_name;
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        if ($outp == null) {
            return null;
        } else {
            return $outp;
        }
    }

}