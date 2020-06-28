<?php
require_once 'config/__db_config.block.php';


class UserDetails
{

    private $block;
    private $vill_name;
    private $con;

    public function __construct($block, $vill_name)
    {
        $this->block = $block;
        $this->vill_name = $vill_name;
        $this->con = DB_Config::getInstance()->getConnection();
    }

    public function getId()
    {
        $vill_name = strtolower($this->vill_name);
        if (strpos($vill_name, "_")) {
            $vill_name = str_replace("_", " ", $vill_name);
        }
        if (strcmp($this->block, "Agustyamuni") == 0) {
            $selectQuery = "SELECT uq_id FROM  Agustyamuni WHERE vill_name = ?";
        } else if (strcmp($this->block, "Jakholi") == 0) {
            $selectQuery = "SELECT uq_id FROM  Jakholi WHERE vill_name = ?";
        } else {
            $selectQuery = "SELECT uq_id FROM  Ukhimath WHERE vill_name = ?";
        }

        if ($stmt = $this->con->prepare($selectQuery)) {
            $stmt->bind_param("s", $vill_name);
            $stmt->execute();
            $stmt->bind_result($id);
            if ($stmt->fetch()) {
                $stmt->close();
                return $id;
            }
            $stmt->close();
            return 0;
        }
        return 0;
    }

    public function getName()
    {
        $selectQuery = "SELECT full_name FROM  login WHERE uq_id = ?";
        if ($stmt = $this->con->prepare($selectQuery)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($name);
            if ($stmt->fetch()) {
                $stmt->close();
                return $name;
            }
            $stmt->close();
            return null;
        }
        return null;
    }
}