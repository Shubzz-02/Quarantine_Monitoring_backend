<?php



class DB_CONFIG
{
    protected static $_instance = null;
    protected $_conn = null;
    protected $_bconn = null;

    protected $_config = array(
        'username' => 'pmhnsmlo_users',
        'password' => 'JK0VHKcQE6',
        'hostname' => 'localhost',
        'database' => 'pmhnsmlo_users'
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
        if ($block == "Agustyamuni") {
            $database = "sql12337403";
            if (is_null($this->_bconn)) {
                $db = $this->_config;
                $this->_bconn = mysqli_connect("sql12.freemysqlhosting.net", "sql12337403", "XR9skmD9WF");
                if (!$this->_bconn) {
                    die("Cannot connect to database server");
                }
                if (!mysqli_select_db($this->_bconn, $database)) {
                    die("Cannot select database");
                }
            }
        } else if ($block == 'Jakholi') {
            $database = $block;
        } else {
            $database = $block;
        }

        return $this->_bconn;
    }

    public function query($query)
    {
        $conn = $this->getConnection();
        return mysqli_query($query, $conn);
    }

}