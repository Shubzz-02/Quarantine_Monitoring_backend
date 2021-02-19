<?php

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
require_once '__login.block.php';
require_once '__register.block.php';
require_once '__user.block.php';
require_once '__refresh.block.php';
require_once '__addvill.block.php';
require_once '__getvilldata.block.php';
require_once '__addperson.block.php';
require_once '__mark.block.php';

$header = getallheaders();
$response = null;
$inputJSON = file_get_contents('php://input');

if (key_exists('X-Reaq', $header)) {
    $start = new Index($header, $inputJSON);
    $start->getRequest();
}else{
    header("Location: ".__DIR__."/admin/");
    exit;
}

class Index
{
    private $_response = null;
    private $_input = null;
    private $_header = null;
    private $_param = null;
    private $_raw = null;

    public function __construct($header, $inputJSON)
    {
        $this->_header = $header;
        $this->_input = json_decode($inputJSON, TRUE);
        $this->_raw = $inputJSON;
    }

    public function getRequest()
    {
        if (key_exists('X-Reaq', $this->_header)) {
            $rea_q = trim($this->_header['X-Reaq']);
            if (strcasecmp($rea_q, "e469b5d0") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['password'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'password' => $this->_input['password']
                    );
                    if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['password'])) >= 8) {
                        $login = new Login($this->_param['username'], $this->_param['password']);
                        $this->_response = $login->loginUser();
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Password length must be 8"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "a34c9f37") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['password']) && isset($this->_input['block']) &&
                    isset($this->_input['full_name'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'password' => $this->_input['password'],
                        'block' => trim($this->_input['block']),
                        'full_name' => trim($this->_input['full_name'])
                    );
                    if (strcmp($this->_param['block'], "Agustyamuni") == 0 || strcmp($this->_param['block'], "Jakholi") == 0
                        || strcmp($this->_param['block'], "Ukhimath") == 0) {
                        if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['password'])) >= 8 && (int)(strlen($this->_param['full_name']) >= 3)) {
                            $register = new Register($this->_param['full_name'], $this->_param['username'], $this->_param['password'], $this->_param['block']);
                            $this->_response = $register->registerUser();
                        } else {
                            $this->_response = array(
                                'status' => 4,
                                'message' => "Details Must be submitted as specified"
                            );
                        }
                    } else {
                        $this->_response = array(
                            'status' => 2,
                            'message' => "Please Enter Correct Block"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "2acb85cf") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['uq_key'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'uq_key' => trim($this->_input['uq_key'])
                    );
                    if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['uq_key'])) > 30) {
                        $verify = new User($this->_param['username'], $this->_param['uq_key']);
                        $this->_response = $verify->verifyUser();
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "799182d8") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['uq_key'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'uq_key' => trim($this->_input['uq_key'])
                    );
                    if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['uq_key'])) > 30) {
                        $verify = new User($this->_param['username'], $this->_param['uq_key']);
                        $this->_response = $verify->verifyUser();
                        if ($this->_response['status'] != 0) {
                            $this->_response = array(
                                'status' => 1,
                                'message' => "Not Authorized"
                            );
                        } else {
                            $refresh = new Refresh($this->_param['username'], $this->_param['uq_key'], $verify->getBlock());
                            $this->_response = $refresh->refresh();
                        }
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "a8737537") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['uq_key'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'uq_key' => trim($this->_input['uq_key']),
                        'vill_name' => trim($this->_input['vill_name'])
                    );
                    if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['uq_key'])) > 30 && (int)(strlen($this->_param['vill_name']) > 2)) {
                        $verify = new User($this->_param['username'], $this->_param['uq_key']);
                        $this->_response = $verify->verifyUser();
                        if ($this->_response['status'] != 0) {
                            $this->_response = array(
                                'status' => 1,
                                'message' => "Not Authorized"
                            );
                        } else {
                            $add = new AddVill($this->_param['username'], $this->_param['uq_key'], $this->_param['vill_name'], $verify->getBlock(), $verify->getId());
                            $this->_response = $add->addVill();
                        }
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "800598b7") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['uq_key'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'uq_key' => trim($this->_input['uq_key'])
                    );
                    if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['uq_key'])) > 30) {
                        $verify = new User($this->_param['username'], $this->_param['uq_key']);
                        $this->_response = $verify->verifyUser();
                        if ($this->_response['status'] != 0) {
                            $this->_response = array(
                                'status' => 1,
                                'message' => "Not Authorized"
                            );
                        } else {
                            $id = $verify->getId();
                            $block = $verify->getBlock();
                            $vill_name = $verify->getVillName($id, $block);
                            if ($vill_name != null) {
                                $this->_response = array(
                                    'status' => 0,
                                    'message' => "successful",
                                    'vill_name' => $vill_name
                                );
                            } else {
                                $this->_response = array(
                                    'status' => 1,
                                    'message' => "No Village"
                                );
                            }
                        }
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "03539ace") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['uq_key']) && isset($this->_input['vill_name'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'uq_key' => trim($this->_input['uq_key']),
                        'vill_name' => trim($this->_input['vill_name'])
                    );
                    if ((int)(strlen($this->_param['username'])) == 10 && (int)(strlen($this->_param['uq_key'])) > 30 && (int)(strlen($this->_param['vill_name'])) > 2) {
                        $verify = new User($this->_param['username'], $this->_param['uq_key']);
                        $this->_response = $verify->verifyUser();
                        if ($this->_response['status'] != 0) {
                            $this->_response = array(
                                'status' => 1,
                                'message' => "Not Authorized"
                            );
                        } else {
                            $id = $verify->getId();
                            $block = $verify->getBlock();
                            $vill_name = $verify->getVillName($id, $block);
                            if ($vill_name != null) {
                                if (strcasecmp($this->_param['vill_name'], $vill_name) == 0) {
                                    $getV = new VillData($vill_name, $block);
                                    $data = $getV->getVillData();
                                    if ($data != null) {
                                        $d = base64_decode($data);
                                        $this->_response = json_decode($d, true);
                                    }
                                } else {
                                    $this->_response = array(
                                        'status' => 1,
                                        'message' => "Not Authorized"
                                    );
                                }
                            } else {
                                $this->_response = array(
                                    'status' => 1,
                                    'message' => "No Data"
                                );
                            }
                        }
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "9b201a40") == 0) {
                if (isset($this->_input['username']) && isset($this->_input['uq_key']) && isset($this->_input['vill_name']) && isset($this->_input['pname']) && isset($this->_input['fname'])
                    && isset($this->_input['cdate']) && isset($this->_input['gender']) && isset($this->_input['pno']) && isset($this->_input['age']) && isset($this->_input['cfrom'])) {
                    $this->_param = array(
                        'username' => trim($this->_input['username']),
                        'uq_key' => trim($this->_input['uq_key']),
                        'vill_name' => trim($this->_input['vill_name']),
                        'pname' => trim($this->_input['pname']),
                        'fname' => trim($this->_input['fname']),
                        'cdate' => trim($this->_input['cdate']),
                        'gender' => trim($this->_input['gender']),
                        'pno' => trim($this->_input['pno']),
                        'age' => trim($this->_input['age']),
                        'cfrom' => trim($this->_input['cfrom'])
                    );
//                    echo $this->_param['username']." ".(int)(strlen($this->_param['username']))."\n";
//                    echo $this->_param['uq_key']."\n";
//                    echo $this->_param['vill_name']."\n";
//                    echo $this->_param['fname']."\n";
//                    echo $this->_param['cdate']." ".preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->_param['cdate'])."\n";
//                    echo $this->_param['gender']." ".(strcasecmp($this->_input['gender'], "male") == 0 || strcasecmp($this->_input['gender'], "female") == 0 || strcasecmp($this->_input['gender'], "other") == 0)."\n";
//                    echo $this->_param['pno']."\n";
//                    echo $this->_param['age']." ".(((int)trim($this->_param["age"]) >= 0 && (int)trim($this->_param["age"]) < 110))."\n";
//                    echo $this->_param['cfrom']."\n";
//                    if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->_param['cdate'])){
//                        echo "date sahi h"."\n";
//                    }
//                    if((((int)trim($this->_param["age"]) >= 0 && (int)trim($this->_param["age"]) < 110))){
//                        echo "age bhi sahi h"."\n";
//                    }
//                    if((strcasecmp($this->_input['gender'], "male") == 0 || strcasecmp($this->_input['gender'], "female") == 0 || strcasecmp($this->_input['gender'], "other") == 0)){
//                        echo "gender bhi sahi h"."\n";
//                    }
//                    //echo "class: ".get_class((strlen($this->_param['username'])))."\n";
//                    if(((int)(strlen($this->_param['username'])) == (int)10)){
//                        echo "number bhi sahi h"."\n";
//                    }
//                    if(((int)(strlen($this->_param['uq_key'])) > 30)){
//                        echo "uq sahi h"."\n";
//                    }
//                    if(((int)strlen($this->_param['vill_name'] > (int)2)) == 0){
//                        echo "vill sahi h"."\n";
//                    }else{
//                        echo $this->_param['vill_name']." ".strlen($this->_param['vill_name'])."\n";
//                    }


                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $this->_param['cdate']) && (((int)trim($this->_param["age"]) >= 0 && (int)trim($this->_param["age"]) < 110))
                        && (strcasecmp($this->_input['gender'], "male") == 0 || strcasecmp($this->_input['gender'], "female") == 0 || strcasecmp($this->_input['gender'], "other") == 0) &&
                        ((int)(strlen($this->_param['username'])) == 10) && (int)(strlen($this->_param['uq_key'])) > 30) {
                        $verify = new User($this->_param['username'], $this->_param['uq_key']);
                        $this->_response = $verify->verifyUser();
                        if ($this->_response['status'] != 0) {
                            $this->_response = array(
                                'status' => 1,
                                'message' => "Not Authorized"
                            );
                        } else {
                            $id = $verify->getId();
                            $block = $verify->getBlock();
                            $vill_name = $verify->getVillName($id, $block);
                            if (strcasecmp($vill_name, $this->_param['vill_name']) == 0) {
                                $add = new AddPerson($vill_name, $block, $this->_param['pname'], $this->_param['fname'], $this->_param['cdate']
                                    , $this->_param['gender'], $this->_param['pno'], $this->_param['age'], $this->_param['cfrom']);
                                $this->_response = $add->addPerson();
                            } else {
                                $this->_response = array(
                                    'status' => 1,
                                    'message' => "Not Authorized"
                                );
                            }
                        }
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Missing mandatory parameters"
                    );
                }
            } elseif (strcasecmp($rea_q, "9e3f601b") == 0) {
                if (key_exists('X-Uname', $this->_header) && key_exists('X-Key', $this->_header)
                    && key_exists('X-Vill', $this->_header)) {
                    $username = trim($this->_header['X-Uname']);
//                    echo $username."\n";
                    $key = trim($this->_header['X-Key']);
//                    echo $key."\n";
                    $vill = trim($this->_header['X-Vill']);
                    if ((int)strlen($username) == (int)10 && (int)strlen($key) > (int)30 && ((int)strlen($vill) > (int)3)) {
                        $verify = new User($username,$key);
                        $this->_response = $verify->verifyUser();
                        if ($this->_response['status'] != 0) {
                            $this->_response = array(
                                'status' => 1,
                                'message' => "Not Authorized"
                            );
                        } else {
                            $id = $verify->getId();
                            $block = $verify->getBlock();
                            $vill_name = $verify->getVillName($id, $block);
                            if (strcasecmp($vill_name, $vill) == 0) {
                                $mark = new Mark($vill_name,$block,$this->_raw);
                                $this->_response = $mark->markAtted();
                            } else {
                                $this->_response = array(
                                    'status' => 1,
                                    'message' => "Not Authorized"
                                );
                            }
                        }
                    } else {
                        $this->_response = array(
                            'status' => 4,
                            'message' => "Details Must be submitted as specified"
                        );
                    }
                } else {
                    $this->_response = array(
                        'status' => 2,
                        'message' => "Something went wrong"
                    );
                }
            }
        } else {
            $this->_response = array(
                'status' => 2,
                'message' => "Something went wrong"
            );
        }
        echo json_encode($this->_response);
    }

}




//e469b5d0   login
//a34c9f37   register
//2acb85cf   verify
//799182d8   refresh
//a8737537   add vill
//800598b7   get vill name
//03539ace   get vill data
//9b201a40   add person
//9e3f601b   attend
