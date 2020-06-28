<?php


class DB_Config
{
    protected static $_instance = null;
    protected $_conn = null;
    protected $_bconn = null;

    protected $_config = array(
        'username' => 'web',
        'password' => 'password',
        'hostname' => 'localhost',
        'database' => 'users'
    );

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection()
    {
        if (is_null($this->_conn)) {
            $db = $this->_config;
            $this->_conn = mysqli_connect($db['hostname'], $db['username'], $db['password']);
            if (!$this->_conn) {
                die("Cannot connect to database server");
            }
            if (!mysqli_select_db($this->_conn, $db['database'])) {
                die("Cannot select database");
            }
        }
        return $this->_conn;
    }

    public function getBlockConnection($block)
    {
        $database = null;
        if (strcmp($block, "Agustyamuni") == 0) {
            $database = $block;
        } else if (strcmp($block,'Jakholi') == 0) {
            $database = $block;
        } else {
            $database = $block;
        }
        if (is_null($this->_bconn)) {
            $db = $this->_config;
            $this->_bconn = mysqli_connect($db['hostname'], $db['username'], $db['password']);
            if (!$this->_bconn) {
                die("Cannot connect to database server");
            }
            if (!mysqli_select_db($this->_bconn, $database)) {
                die("Cannot select database");
            }
        }
        return $this->_bconn;
    }

}